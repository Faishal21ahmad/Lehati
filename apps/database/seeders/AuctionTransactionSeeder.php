<?php

namespace Database\Seeders;

use App\Models\Bid;
use Illuminate\Database\Seeder;
use App\Models\AuctionTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuctionTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winnerBids = Bid::where('is_winner', true)->get();
        
        foreach ($winnerBids as $bid) {
            AuctionTransaction::factory()->create([
                'bid_id' => $bid->id,
                'user_id' => $bid->participant->user_id,
                'amount_final' => $bid->amount
            ]);
        }
    }
}
