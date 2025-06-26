<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->randomElement([
                'Padi',
                'Jagung',
                'Kedelai',
                'Cabai',
                'Tomat',
                'Wortel',
                'Kubis',
                'Bayam',
                'Kangkung',
                'Bawang Merah',
                'Bawang Putih',
                'Kentang',
                'Timun',
                'Terong',
                'Kacang Panjang'
            ]),
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 100),
            'units' => $this->faker->randomElement(['kg', 'ton', 'ons', 'ikat']),
            'status' => $this->faker->randomElement(['available', 'sold']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
