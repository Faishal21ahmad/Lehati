<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_transaksi' => fn() => now()->format('dmy') . $this->faker->unique()->numberBetween(1000, 9999),
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'failed', 'success']),
            'payment_proof' => $this->faker->optional()->imageUrl(),
            'notes' => $this->faker->optional()->sentence,
            'amount_final' => $this->faker->randomFloat(2, 10000, 200000),
            'payment_verified_at' => $this->faker->optional()->dateTimeThisMonth,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
