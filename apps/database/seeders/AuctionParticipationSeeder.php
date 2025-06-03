<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AuctionRoom;
use Illuminate\Database\Seeder;
use App\Models\AuctionParticipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuctionParticipationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = AuctionRoom::all();
        $bidders = User::where('role', 'bidder')->get();

        foreach ($rooms as $room) {
            $participants = $bidders->random(15);

            foreach ($participants as $bidder) {
                AuctionParticipant::factory()->create([
                    'user_id' => $bidder->id,
                    'auction_room_id' => $room->id,
                    'status' => 'joined'
                ]);
            }
        }
    }
}
