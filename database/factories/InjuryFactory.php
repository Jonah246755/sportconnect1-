<?php

namespace Database\Factories;

use App\Models\Injury;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class InjuryFactory extends Factory
{
    protected $model = Injury::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'type' => $this->faker->randomElement(['Ankle Sprain', 'Hamstring', 'Knee', 'Shoulder', 'Back']),
            'description' => $this->faker->sentence(),
            'injury_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'expected_recovery_date' => $this->faker->optional()->dateTimeBetween('now', '+2 months'),
            'actual_recovery_date' => null,
            'status' => 'active',
        ];
    }

    public function recovered(): static
    {
        return $this->state(fn (array $attributes) => [
            'actual_recovery_date' => $this->faker->dateTimeBetween($attributes['injury_date'], 'now'),
            'status' => 'recovered',
        ]);
    }
}
