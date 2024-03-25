<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array<string, mixed>
     */
    private $data;
    private User $user;
    private Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
        $this->data = Task::factory()->make()->only('name', 'description', 'status_id', 'assigned_to_id');
        $this->task = Task::factory()->create();
    }

    public function testGuestCanViewTaskList(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testGuestCanViewTaskDetails(): void
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertOk();
    }

    public function testGuestCannotStoreTasks(): void
    {
        $response = $this->post(route('tasks.store'), $this->data);
        $response->assertStatus(403);
    }

    public function testGuestCannotEditTasks(): void
    {
        $response = $this->get(route('tasks.edit', [$this->task]));
        $response->assertStatus(403);
    }

    public function testGuestCannotUpdateTasks(): void
    {
        $response = $this->patch(route('tasks.update', [$this->task]), $this->data);
        $response->assertStatus(403);
    }

    public function testGuestCannotDestroyTasks(): void
    {
        $response = $this->get(route('tasks.create', [$this->task]));
        $response->assertStatus(403);
    }

    public function testUserCanCreateTasks(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testUserCanStoreTasks(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('tasks.store'), $this->data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $this->data);
    }

    public function testUserCanEditTasks(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.edit', [$this->task]));
        $response->assertOk();
    }

    public function testUserCanUpdateTasks(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch(route('tasks.update', [$this->task]), $this->data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $this->data);
    }

    public function testOnlyCreatorCanDestroyTasks(): void
    {
        $taskData = Task::factory()->make()->only('name', 'description', 'status_id', 'assigned_to_id');
        $task = new Task($taskData);
        $task->created_by_id = $this->user->id;
        $task->save();

        $user2 = User::factory()->create();
        $response = $this
            ->actingAs($user2)
            ->delete(route('tasks.destroy', [$task]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', $task->only('id'));

        $response = $this
            ->actingAs($this->user)
            ->delete(route('tasks.destroy', [$task]));
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }
}
