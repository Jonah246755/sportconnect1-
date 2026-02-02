<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Player;
use App\Models\Injury;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InjuryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Player $player;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $sport = Sport::factory()->create();
        $team = Team::factory()->create(['sport_id' => $sport->id]);
        $this->player = Player::factory()->create(['team_id' => $team->id]);
    }

    public function test_injuries_index_page_displays_correctly()
    {
        Injury::factory()->create([
            'player_id' => $this->player->id,
            'type' => 'Ankle Sprain',
        ]);

        $response = $this->actingAs($this->user)->get(route('injuries.index'));

        $response->assertStatus(200);
        $response->assertSee('Ankle Sprain');
        $response->assertSee($this->player->name);
    }

    public function test_can_create_an_injury()
    {
        $response = $this->actingAs($this->user)->post(route('injuries.store'), [
            'player_id' => $this->player->id,
            'type' => 'Hamstring',
            'description' => 'Pulled hamstring during training',
            'injury_date' => now()->format('Y-m-d'),
            'expected_recovery_date' => now()->addWeeks(2)->format('Y-m-d'),
            'status' => 'active',
        ]);

        $response->assertRedirect(route('injuries.index'));
        $this->assertDatabaseHas('injuries', [
            'player_id' => $this->player->id,
            'type' => 'Hamstring',
        ]);
    }

    public function test_injury_shows_as_active_on_player()
    {
        Injury::factory()->create([
            'player_id' => $this->player->id,
            'status' => 'active',
        ]);

        $this->assertTrue($this->player->isInjured());
    }

    public function test_can_update_injury_status_to_recovered()
    {
        $injury = Injury::factory()->create([
            'player_id' => $this->player->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->put(route('injuries.update', $injury), [
            'player_id' => $this->player->id,
            'type' => $injury->type,
            'injury_date' => $injury->injury_date->format('Y-m-d'),
            'actual_recovery_date' => now()->format('Y-m-d'),
            'status' => 'recovered',
        ]);

        $response->assertRedirect(route('injuries.index'));
        $this->assertDatabaseHas('injuries', [
            'id' => $injury->id,
            'status' => 'recovered',
        ]);
    }

    public function test_can_delete_an_injury()
    {
        $injury = Injury::factory()->create(['player_id' => $this->player->id]);

        $response = $this->actingAs($this->user)->delete(route('injuries.destroy', $injury));

        $response->assertRedirect(route('injuries.index'));
        $this->assertDatabaseMissing('injuries', ['id' => $injury->id]);
    }

    public function test_injury_show_displays_duration_and_status()
    {
        $injury = Injury::factory()->create([
            'player_id' => $this->player->id,
            'injury_date' => now()->subDays(5),
        ]);

        $response = $this->actingAs($this->user)->get(route('injuries.show', $injury));

        $response->assertStatus(200);
        $response->assertSee('Duur');
        $response->assertSee('dagen');
    }
}
