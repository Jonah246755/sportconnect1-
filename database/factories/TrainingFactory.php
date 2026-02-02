<?php

namespace Database\Factories;

use App\Models\Training;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'scheduled_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'location' => $this->faker->address(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
