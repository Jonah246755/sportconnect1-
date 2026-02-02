<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'team_id' => Team::factory(),
            'position' => $this->faker->word(),
            'jersey_number' => $this->faker->numberBetween(1, 99),
        ];
    }
}
