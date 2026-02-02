<?php

namespace Database\Factories;

use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameMatchFactory extends Factory
{
    protected $model = GameMatch::class;

    public function definition(): array
    {
        return [
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'scheduled_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'location' => $this->faker->address(),
            'home_score' => null,
            'away_score' => null,
            'status' => 'scheduled',
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'home_score' => $this->faker->numberBetween(0, 5),
            'away_score' => $this->faker->numberBetween(0, 5),
            'status' => 'completed',
        ]);
    }
}
