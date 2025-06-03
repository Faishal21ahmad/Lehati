<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\AuctionRoom;
use Illuminate\Database\Seeder;
use App\Models\AuctionParticipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BidsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $participants = AuctionParticipant::all();

        foreach ($participants as $participant) {
            $bidCount = rand(1, 5);

            for ($i = 0; $i < $bidCount; $i++) {
                Bid::factory()->create([
                    'participan_id' => $participant->id,
                    'auction_room_id' => $participant->auction_room_id,
                ]);
            }
        }

        // Set one bid as winner for each room
        $rooms = AuctionRoom::all();
        foreach ($rooms as $room) {
            $winnerBid = $room->bids()->inRandomOrder()->first();
            if ($winnerBid) {
                $winnerBid->update(['is_winner' => true]);
            }
        }
    }
}
