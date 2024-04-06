<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;

/**
 * @property array $newLabelData
 * @property array $updateLabelData
 */
class LabelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
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

    public function testCreateNonAuth(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertStatus(403);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStoreNonAuth(): void
    {
        $response = $this->post(route('labels.store'), $this->newLabelData);

        $response->assertStatus(403);
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)->post(route('labels.store'), $this->newLabelData);

        $this->assertDatabaseHas('labels', $this->newLabelData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label));

        $response->assertOk();
    }

    public function testEditNonAuth(): void
    {
        $response = $this->get(route('labels.edit', $this->label));

        $response->assertStatus(403);
    }

    public function testUpdate(): void
    {
        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $this->label), $this->updateLabelData);

        $this->assertDatabaseHas('labels', $this->updateLabelData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
    }

    public function testUpdateNonAuth(): void
    {
        $response = $this->patch(route('labels.update', $this->label), $this->newLabelData);

        $response->assertStatus(403);
    }

    public function testDestroyNonAuth(): void
    {
        $response = $this->delete(route('labels.destroy', $this->label));

        $response->assertStatus(403);
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
}
