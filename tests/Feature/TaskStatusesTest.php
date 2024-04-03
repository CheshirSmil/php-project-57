<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class TaskStatusesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->taskStatusData = TaskStatus::factory()->make()->only([
            'name',
        ]);
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

    public function testCreateNonAuth(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(403);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStoreNonAuth(): void
    {
        $response = $this->post(route('task_statuses.store'), $this->taskStatusData);

        $response->assertStatus(403);
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $this->newTaskStatusData);

        $this->assertDatabaseHas('task_statuses', $this->newTaskStatusData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testEditNonAuth(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertStatus(403);
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertOk();
    }

    public function testUpdateNonAuth(): void
    {
        $response = $this->patch(route('task_statuses.update', $this->taskStatus), $this->taskStatusData);

        $response->assertStatus(403);
    }

    public function testUpdate(): void
    {
        $response = $this->actingAs($this->user)
            ->put(route('task_statuses.update', $this->taskStatus), $this->updateTaskStatusData);

        $this->assertDatabaseHas('task_statuses', $this->updateTaskStatusData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testDestroyNonAuth(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertStatus(403);
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', $this->taskStatus->only('id'));
    }
}
