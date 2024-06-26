<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::pluck('name', 'id');
        $statuses = TaskStatus::pluck('name', 'id');
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                [
                    AllowedFilter::exact('status_id'),
                    AllowedFilter::exact('created_by_id'),
                    AllowedFilter::exact('assigned_to_id')
                ]
            )
            ->orderBy('id', 'asc')
            ->paginate(15);

        $filter = $request->filter ?? null;

        return view('tasks.index', compact('tasks', 'statuses', 'users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.create', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated();

        $data = $request->except('labels');
        $data['created_by_id'] = optional(auth()->user())->id;

        $labels = collect($request->input('labels'))
            ->filter(fn($label) => $label !== null);

        $task = Task::create($data);

        $task->labels()->attach($labels);

        session()->flash('success', __('layout.task.flash_create_success'));
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.edit', compact('task', 'users', 'statuses', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $request->validated();

        $data = $request->except('labels');

        $labels = collect($request->input('labels'))
            ->filter(fn($label) => $label !== null);

        $task->update($data);

        $task->labels()->sync($labels);

        session()->flash('success', __('layout.task.flash_update_success'));

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();

        session()->flash('success', __('layout.task.flash_delete_success'));

        return redirect()
            ->route('tasks.index');
    }
}
