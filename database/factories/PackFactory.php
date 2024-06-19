<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pack>
 */
class PackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'duration' => $this->faker->numberBetween(1, 31),
            'trainings_number' => $this->faker->numberBetween(1, 10),
            'has_personal_trainer' => $this->faker->boolean,
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
