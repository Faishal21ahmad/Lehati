<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AuctioneerLog;
use App\Models\AuctioneerData;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuctioneerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auctioneers = User::where('role', 'auctioneer')->get();

        $i = 0;

        foreach ($auctioneers as $auctioneer) {
            $auctioneerData = AuctioneerData::factory()->create([
                'user_id' => $auctioneer->id,
                'business_name' => 'Pak Tani' . $i++,
                'status' => 'approved'
            ]);

            // Create logs for each auctioneer
            AuctioneerLog::factory()->create([
                'auctioneer_id' => $auctioneerData->id,
                'status' => 'approved',
                'action_by' => User::where('role', 'admin')->first()->id
            ]);
        }
    }
}
