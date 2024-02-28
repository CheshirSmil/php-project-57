<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskStatusesTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private User $wrongUser;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory([
            'creator_id' => $this->user->id,
        ])->create();
        $this->wrongUser = User::factory()->create();
    }

    public function testGuestCanViewTaskStatusList(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOK();
    }

    public function testGuestCannotCreateTaskStatuses(): void
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
        $response = $this->post(route('task_statuses.store'), [
            'name' => fake()->name(),
        ]);

        $response->assertForbidden();
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), [
            'name' => fake()->name(),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testEditNonAuth(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus->id));
        $response->assertForbidden();
    }

    public function testEditWrongUser(): void
    {
        $response = $this->actingAs($this->wrongUser)->get(route('task_statuses.edit', $this->taskStatus->id));
        $response->assertForbidden();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->taskStatus->id));
        $response->assertOk();
    }

    public function testUpdateNonAuth(): void
    {
        $response = $this->put(route('task_statuses.update', $this->taskStatus->id), [
            'name' => fake()->name(),
        ]);

        $response->assertForbidden();
    }

    public function testUpdateWrongUser(): void
    {
        $response = $this->actingAs($this->wrongUser)->put(route('task_statuses.update', $this->taskStatus->id), [
            'name' => fake()->name(),
        ]);
        $response->assertForbidden();
    }

    public function testUpdate(): void
    {
        $response = $this->actingAs($this->user)->put(route('task_statuses.update', $this->taskStatus->id), [
            'name' => fake()->name(),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testDestroyNonAuth(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus->id));
        $response->assertForbidden();
    }

    public function testDestroyWrongUser(): void
    {
        $response = $this->actingAs($this->wrongUser)->delete(route('task_statuses.destroy', $this->taskStatus->id));
        $response->assertForbidden();
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $this->taskStatus->id));
        $this->assertModelMissing($this->taskStatus);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
    }
}
