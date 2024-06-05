<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1,3),
            'name' => $this->faker->name,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
