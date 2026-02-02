<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Team',
            'sport_id' => Sport::factory(),
            'age_group' => $this->faker->randomElement(['U13', 'U15', 'U18', 'U21', 'Senior']),
            'description' => $this->faker->sentence(),
        ];
    }
}
