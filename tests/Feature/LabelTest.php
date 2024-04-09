<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;
use App\Models\Task;

class LabelTest extends TestCase
{
    private array $newLabelData;
    private array $updateLabelData;
    private User $user;
    private Label $label;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
        $this->task = Task::factory([
            'created_by_id' => $this->user->id,
        ])->create();
        $this->label = Label::factory()->create();

        $this->newLabelData = Label::factory()
            ->make()
            ->only([
                'name',
                'description',
            ]);
        $this->updateLabelData = Label::factory()
            ->make()
            ->only([
                'name',
                'description',
            ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)->post(route('labels.store'), $this->newLabelData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $this->newLabelData);
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $this->label), $this->updateLabelData);

        $this->assertDatabaseHas('labels', $this->updateLabelData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
    }

    public function testDestroy(): void
    {
        $this->actingAs(User::factory()->create());

        $model = Label::factory()->create();
        $response = $this->delete(route('labels.destroy', $model));

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('labels', ['id' => $model->id]);
    }

    public function testDeleteIfLinkWithTask(): void
    {
        $this->actingAs(User::factory()->create());

        $model = Label::factory()->create();
        $this->task->labels()->attach(['label' => $this->label->id]);

        $response = $this->delete(route('labels.destroy', ['label' => $model->id]));
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }
}
