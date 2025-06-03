<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuctioneerData>
 */
class AuctioneerDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_name' => 'PT.test 123',
            'business_address' => 'Jl. Test No. 123',
            'NPWP' => $this->faker->numerify('##.###.###.#-###.###'),
            'status' => $this->faker->randomElement(['request', 'processing', 'approved', 'rejected', 'revoked']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
