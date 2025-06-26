<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;
use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ParticipationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::all();
        $bidders = User::where('role', 'bidder')->get();

        foreach ($rooms as $room) {
            $participants = $bidders->random(15);

            foreach ($participants as $bidder) {
                Participant::factory()->create([
                    'user_id' => $bidder->id,
                    'room_id' => $room->id,
                    'status' => 'joined'
                ]);
            }
        }
    }
}
