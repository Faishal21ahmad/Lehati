<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Room;
use Illuminate\Database\Seeder;
use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BidsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $participants = Participant::all();
        $lastBidAmounts = [];

        foreach ($participants as $participant) {
            $roomId = $participant->room_id;

            // Mulai dari nilai awal jika belum ada
            if (!isset($lastBidAmounts[$roomId])) {
                $lastBidAmounts[$roomId] = rand(100000, 5000000); // Bid awal per room
            }

            $bidCount = rand(1, 5);

            for ($i = 0; $i < $bidCount; $i++) {
                // Tambahkan jumlah acak agar terus naik
                $increment = rand(1000, 10000);
                $lastBidAmounts[$roomId] += $increment;

                Bid::factory()->create([
                    'participan_id' => $participant->id,
                    'room_id' => $roomId,
                    'amount' => $lastBidAmounts[$roomId],
                ]);
            }
        }

        // Set one bid as winner for each room
        $rooms = Room::all();
        foreach ($rooms as $room) {
            $winnerBid = $room->bids()->inRandomOrder()->first();
            if ($winnerBid) {
                $winnerBid->update(['is_winner' => true]);
            }
        }
    }
}
