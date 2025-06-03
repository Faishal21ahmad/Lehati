<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuctionRoom>
 */
class AuctionRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+1 week');
        $endTime = $this->faker->dateTimeBetween($startTime, '+2 weeks');

        return [
            'room_code' => 'RM' . $this->faker->unique()->numberBetween(1000, 9999),
            'title_room' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['upcoming', 'ongoing', 'ended', 'cancelled']),
            'starting_price' => $this->faker->randomFloat(2, 10000, 100000),
            'min_bid_step' => $this->faker->randomFloat(2, 1000, 5000),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
