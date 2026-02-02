<?php

namespace Database\Seeders;

use App\Models\Sport;
use App\Models\Team;
use App\Models\Player;
use App\Models\Training;
use App\Models\GameMatch;
use App\Models\Injury;
use App\Models\TrainingAttendance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        User::create([
            'name' => 'Test Admin',
            'email' => 'admin@sportconnect.nl',
            'password' => Hash::make('password'),
        ]);

        // Create Sports
        $football = Sport::create([
            'name' => 'Voetbal',
            'description' => 'De populairste sport ter wereld',
        ]);

        $basketball = Sport::create([
            'name' => 'Basketbal',
            'description' => 'Een dynamische teamsport',
        ]);

        $hockey = Sport::create([
            'name' => 'Hockey',
            'description' => 'Een snelle stick-sport',
        ]);

        // Create Football Teams
        $teamA1 = Team::create([
            'name' => 'Ajax A1',
            'sport_id' => $football->id,
            'age_group' => 'Senioren',
            'description' => 'Eerste elftal',
        ]);

        $teamB1 = Team::create([
            'name' => 'Ajax B1',
            'sport_id' => $football->id,
            'age_group' => 'U21',
            'description' => 'Tweede elftal',
        ]);

        // Create Basketball Team
        $basketTeam = Team::create([
            'name' => 'Lakers U18',
            'sport_id' => $basketball->id,
            'age_group' => 'U18',
            'description' => 'Jeugd basketbal team',
        ]);

        // Create Players for Team A1
        $player1 = Player::create([
            'name' => 'Jan de Vries',
            'email' => 'jan@example.com',
            'date_of_birth' => '1995-05-15',
            'team_id' => $teamA1->id,
            'position' => 'Aanvaller',
            'jersey_number' => 10,
        ]);

        $player2 = Player::create([
            'name' => 'Pieter Janssen',
            'email' => 'pieter@example.com',
            'date_of_birth' => '1998-08-22',
            'team_id' => $teamA1->id,
            'position' => 'Verdediger',
            'jersey_number' => 5,
        ]);

        $player3 = Player::create([
            'name' => 'Klaas Bakker',
            'email' => 'klaas@example.com',
            'date_of_birth' => '1997-03-10',
            'team_id' => $teamA1->id,
            'position' => 'Middenvelder',
            'jersey_number' => 8,
        ]);

        // Create Players for Team B1
        $player4 = Player::create([
            'name' => 'Emma van Dam',
            'email' => 'emma@example.com',
            'date_of_birth' => '2003-12-01',
            'team_id' => $teamB1->id,
            'position' => 'Keeper',
            'jersey_number' => 1,
        ]);

        // Create Players for Basketball Team
        $player5 = Player::create([
            'name' => 'Lucas Verhoeven',
            'email' => 'lucas@example.com',
            'date_of_birth' => '2006-07-18',
            'team_id' => $basketTeam->id,
            'position' => 'Point Guard',
            'jersey_number' => 7,
        ]);

        // Create Trainings
        $training1 = Training::create([
            'team_id' => $teamA1->id,
            'scheduled_at' => now()->addDays(2)->setTime(18, 0),
            'location' => 'Hoofdveld',
            'notes' => 'Focus op tactiek',
        ]);

        $training2 = Training::create([
            'team_id' => $teamA1->id,
            'scheduled_at' => now()->subDays(3)->setTime(18, 0),
            'location' => 'Hoofdveld',
        ]);

        // Create Training Attendances for training2 (past)
        TrainingAttendance::create([
            'training_id' => $training2->id,
            'player_id' => $player1->id,
            'attended' => true,
        ]);

        TrainingAttendance::create([
            'training_id' => $training2->id,
            'player_id' => $player2->id,
            'attended' => true,
        ]);

        TrainingAttendance::create([
            'training_id' => $training2->id,
            'player_id' => $player3->id,
            'attended' => false, // Missed training
        ]);

        // Create Training Attendances for training1 (upcoming)
        TrainingAttendance::create([
            'training_id' => $training1->id,
            'player_id' => $player1->id,
            'attended' => false,
        ]);

        TrainingAttendance::create([
            'training_id' => $training1->id,
            'player_id' => $player2->id,
            'attended' => false,
        ]);

        TrainingAttendance::create([
            'training_id' => $training1->id,
            'player_id' => $player3->id,
            'attended' => false,
        ]);

        // Create Matches
        GameMatch::create([
            'home_team_id' => $teamA1->id,
            'away_team_id' => $teamB1->id,
            'scheduled_at' => now()->subDays(7)->setTime(15, 0),
            'location' => 'Hoofdveld',
            'home_score' => 3,
            'away_score' => 1,
            'status' => 'completed',
        ]);

        GameMatch::create([
            'home_team_id' => $teamA1->id,
            'away_team_id' => $teamB1->id,
            'scheduled_at' => now()->addDays(5)->setTime(15, 0),
            'location' => 'Hoofdveld',
            'status' => 'scheduled',
        ]);

        GameMatch::create([
            'home_team_id' => $teamB1->id,
            'away_team_id' => $teamA1->id,
            'scheduled_at' => now()->subDays(14)->setTime(15, 0),
            'location' => 'Uitveld',
            'home_score' => 2,
            'away_score' => 2,
            'status' => 'completed',
        ]);

        // Create Injuries
        Injury::create([
            'player_id' => $player3->id,
            'type' => 'Enkelblessure',
            'description' => 'Verzwikte enkel tijdens training',
            'injury_date' => now()->subDays(10),
            'expected_recovery_date' => now()->addDays(7),
            'status' => 'recovering',
        ]);

        Injury::create([
            'player_id' => $player1->id,
            'type' => 'Hamstring',
            'description' => 'Overbelasting hamstring',
            'injury_date' => now()->subMonths(2),
            'expected_recovery_date' => now()->subMonths(1),
            'actual_recovery_date' => now()->subMonths(1)->addDays(3),
            'status' => 'recovered',
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Email: admin@sportconnect.nl');
        $this->command->info('Password: password');
    }
}
