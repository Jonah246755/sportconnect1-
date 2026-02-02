<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Training;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
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

    public function test_trainings_index_page_displays_correctly()
    {
        Training::factory()->create(['team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->get(route('trainings.index'));

        $response->assertStatus(200);
        $response->assertSee($this->team->name);
    }

    public function test_can_create_a_training()
    {
        Player::factory()->create(['team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->post(route('trainings.store'), [
            'team_id' => $this->team->id,
            'scheduled_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'location' => 'Main Field',
            'notes' => 'Focus on passing',
        ]);

        $response->assertRedirect(route('trainings.index'));
        $this->assertDatabaseHas('trainings', [
            'team_id' => $this->team->id,
            'location' => 'Main Field',
        ]);
    }

    public function test_creating_training_creates_attendance_records()
    {
        $player1 = Player::factory()->create(['team_id' => $this->team->id]);
        $player2 = Player::factory()->create(['team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->post(route('trainings.store'), [
            'team_id' => $this->team->id,
            'scheduled_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
        ]);

        $training = Training::latest()->first();

        $this->assertDatabaseHas('training_attendances', [
            'training_id' => $training->id,
            'player_id' => $player1->id,
        ]);

        $this->assertDatabaseHas('training_attendances', [
            'training_id' => $training->id,
            'player_id' => $player2->id,
        ]);
    }

    public function test_can_update_training_attendance()
    {
        $player = Player::factory()->create(['team_id' => $this->team->id]);
        $training = Training::factory()->create(['team_id' => $this->team->id]);
        $training->attendances()->create([
            'player_id' => $player->id,
            'attended' => false,
        ]);

        $response = $this->actingAs($this->user)->post(route('trainings.attendance', $training), [
            'attendances' => [
                $player->id => true,
            ],
        ]);

        $response->assertRedirect(route('trainings.show', $training));
        $this->assertDatabaseHas('training_attendances', [
            'training_id' => $training->id,
            'player_id' => $player->id,
            'attended' => true,
        ]);
    }

    public function test_can_delete_a_training()
    {
        $training = Training::factory()->create(['team_id' => $this->team->id]);

        $response = $this->actingAs($this->user)->delete(route('trainings.destroy', $training));

        $response->assertRedirect(route('trainings.index'));
        $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
    }
}
