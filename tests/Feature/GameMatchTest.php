<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sport;
use App\Models\Team;
use App\Models\GameMatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameMatchTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Team $homeTeam;
    private Team $awayTeam;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $sport = Sport::factory()->create();
        $this->homeTeam = Team::factory()->create(['sport_id' => $sport->id, 'name' => 'Home Team']);
        $this->awayTeam = Team::factory()->create(['sport_id' => $sport->id, 'name' => 'Away Team']);
    }

    public function test_matches_index_page_displays_correctly()
    {
        GameMatch::factory()->create([
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('matches.index'));

        $response->assertStatus(200);
        $response->assertSee($this->homeTeam->name);
        $response->assertSee($this->awayTeam->name);
    }

    public function test_can_create_a_match()
    {
        $response = $this->actingAs($this->user)->post(route('matches.store'), [
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
            'scheduled_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'location' => 'Stadium',
            'status' => 'scheduled',
        ]);

        $response->assertRedirect(route('matches.index'));
        $this->assertDatabaseHas('matches', [
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
        ]);
    }

    public function test_home_and_away_team_must_be_different()
    {
        $response = $this->actingAs($this->user)->post(route('matches.store'), [
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->homeTeam->id, // Same as home team
            'scheduled_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'status' => 'scheduled',
        ]);

        $response->assertSessionHasErrors('away_team_id');
    }

    public function test_can_update_match_score()
    {
        $match = GameMatch::factory()->create([
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($this->user)->put(route('matches.update', $match), [
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
            'scheduled_at' => $match->scheduled_at->format('Y-m-d H:i:s'),
            'home_score' => 3,
            'away_score' => 2,
            'status' => 'completed',
        ]);

        $response->assertRedirect(route('matches.index'));
        $this->assertDatabaseHas('matches', [
            'id' => $match->id,
            'home_score' => 3,
            'away_score' => 2,
            'status' => 'completed',
        ]);
    }

    public function test_completed_match_shows_winner()
    {
        $match = GameMatch::factory()->create([
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
            'home_score' => 3,
            'away_score' => 1,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->get(route('matches.show', $match));

        $response->assertStatus(200);
        $response->assertSee('Winnaar');
    }

    public function test_can_delete_a_match()
    {
        $match = GameMatch::factory()->create([
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('matches.destroy', $match));

        $response->assertRedirect(route('matches.index'));
        $this->assertDatabaseMissing('matches', ['id' => $match->id]);
    }
}
