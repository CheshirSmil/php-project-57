<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

/**
 * @property array $TaskStatusData
 * @property array $newTaskStatusData
 * @property array $updateTaskStatusData
 */
class TaskStatusesTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;
    //private array $taskStatusData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->actingAs($this->user);
        //$this->taskStatusData = TaskStatus::factory()->make()->only([
            //'name',
        //]);
        $this->newTaskStatusData = TaskStatus::factory()->make()->only([
            'name',
        ]);
        $this->updateTaskStatusData = TaskStatus::factory()->make()->only([
            'name',
        ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $this->newTaskStatusData);

        $this->assertDatabaseHas('task_statuses', $this->newTaskStatusData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this->actingAs($this->user)
            ->put(route('task_statuses.update', $this->taskStatus), $this->updateTaskStatusData);

        $this->assertDatabaseHas('task_statuses', $this->updateTaskStatusData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', $this->taskStatus->only('id'));
    }

    public function testDeleteIfLinkWithTask(): void
    {
        Task::factory()->create(['status_id' => $this->taskStatus->id]);

        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->taskStatus]));
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
