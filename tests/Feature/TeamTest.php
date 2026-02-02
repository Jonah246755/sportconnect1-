<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sport;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Sport $sport;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->sport = Sport::factory()->create();
    }

    public function test_teams_index_page_displays_correctly()
    {
        Team::factory()->create(['name' => 'Team A', 'sport_id' => $this->sport->id]);

        $response = $this->actingAs($this->user)->get(route('teams.index'));

        $response->assertStatus(200);
        $response->assertSee('Team A');
    }

    public function test_can_create_a_team()
    {
        $response = $this->actingAs($this->user)->post(route('teams.store'), [
            'name' => 'Ajax A1',
            'sport_id' => $this->sport->id,
            'age_group' => 'Senior',
            'description' => 'First team',
        ]);

        $response->assertRedirect(route('teams.index'));
        $this->assertDatabaseHas('teams', [
            'name' => 'Ajax A1',
            'sport_id' => $this->sport->id,
        ]);
    }

    public function test_team_requires_valid_sport()
    {
        $response = $this->actingAs($this->user)->post(route('teams.store'), [
            'name' => 'Test Team',
            'sport_id' => 999, // Non-existent sport
        ]);

        $response->assertSessionHasErrors('sport_id');
    }

    public function test_can_update_a_team()
    {
        $team = Team::factory()->create([
            'name' => 'Old Name',
            'sport_id' => $this->sport->id,
        ]);

        $response = $this->actingAs($this->user)->put(route('teams.update', $team), [
            'name' => 'New Name',
            'sport_id' => $this->sport->id,
            'age_group' => 'U21',
        ]);

        $response->assertRedirect(route('teams.index'));
        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_delete_a_team()
    {
        $team = Team::factory()->create(['sport_id' => $this->sport->id]);

        $response = $this->actingAs($this->user)->delete(route('teams.destroy', $team));

        $response->assertRedirect(route('teams.index'));
        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
        ]);
    }

    public function test_can_view_single_team_with_statistics()
    {
        $team = Team::factory()->create([
            'name' => 'Test Team',
            'sport_id' => $this->sport->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('teams.show', $team));

        $response->assertStatus(200);
        $response->assertSee('Test Team');
    }
}
