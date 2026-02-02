<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Team $team;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $sport = Sport::factory()->create();
        $this->team = Team::factory()->create(['sport_id' => $sport->id]);
    }

    public function test_players_index_page_displays_correctly()
    {
        Player::factory()->create(['name' => 'John Doe', 'team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->get(route('players.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
    }

    public function test_can_create_a_player()
    {
        $response = $this->actingAs($this->user)->post(route('players.store'), [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'date_of_birth' => '2000-01-01',
            'team_id' => $this->team->id,
            'position' => 'Forward',
            'jersey_number' => 10,
        ]);

        $response->assertRedirect(route('players.index'));
        $this->assertDatabaseHas('players', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_player_email_must_be_unique()
    {
        Player::factory()->create(['email' => 'duplicate@example.com', 'team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->post(route('players.store'), [
            'name' => 'Another Player',
            'email' => 'duplicate@example.com',
            'date_of_birth' => '1995-05-15',
            'team_id' => $this->team->id,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_can_update_a_player()
    {
        $player = Player::factory()->create([
            'name' => 'Old Name',
            'team_id' => $this->team->id,
        ]);

        $response = $this->actingAs($this->user)->put(route('players.update', $player), [
            'name' => 'New Name',
            'email' => $player->email,
            'date_of_birth' => $player->date_of_birth->format('Y-m-d'),
            'team_id' => $this->team->id,
        ]);

        $response->assertRedirect(route('players.index'));
        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_delete_a_player()
    {
        $player = Player::factory()->create(['team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->delete(route('players.destroy', $player));

        $response->assertRedirect(route('players.index'));
        $this->assertDatabaseMissing('players', ['id' => $player->id]);
    }

    public function test_player_show_page_displays_attendance_and_injuries()
    {
        $player = Player::factory()->create(['team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->get(route('players.show', $player));

        $response->assertStatus(200);
        $response->assertSee($player->name);
        $response->assertSee('Training Aanwezigheid');
    }
}
