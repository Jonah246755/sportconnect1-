<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SportTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_sports_index_page_displays_correctly()
    {
        Sport::factory()->create(['name' => 'Football']);

        $response = $this->actingAs($this->user)->get(route('sports.index'));

        $response->assertStatus(200);
        $response->assertSee('Football');
    }

    public function test_can_create_a_sport()
    {
        $response = $this->actingAs($this->user)->post(route('sports.store'), [
            'name' => 'Basketball',
            'description' => 'A dynamic team sport',
        ]);

        $response->assertRedirect(route('sports.index'));
        $this->assertDatabaseHas('sports', [
            'name' => 'Basketball',
        ]);
    }

    public function test_sport_name_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('sports.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_can_update_a_sport()
    {
        $sport = Sport::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->user)->put(route('sports.update', $sport), [
            'name' => 'New Name',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('sports.index'));
        $this->assertDatabaseHas('sports', [
            'id' => $sport->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_delete_a_sport()
    {
        $sport = Sport::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('sports.destroy', $sport));

        $response->assertRedirect(route('sports.index'));
        $this->assertDatabaseMissing('sports', [
            'id' => $sport->id,
        ]);
    }

    public function test_can_view_single_sport()
    {
        $sport = Sport::factory()->create(['name' => 'Hockey']);

        $response = $this->actingAs($this->user)->get(route('sports.show', $sport));

        $response->assertStatus(200);
        $response->assertSee('Hockey');
    }
}
