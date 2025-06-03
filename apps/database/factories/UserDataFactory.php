<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserData>
 */
class UserDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => '082100000000',
            'address' => $this->faker->address,
            'NIK' => $this->faker->unique()->numerify('################'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
