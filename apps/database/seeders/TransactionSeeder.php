<?php

namespace Database\Seeders;

use App\Models\Bid;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winnerBids = Bid::where('is_winner', true)->get();
        
        foreach ($winnerBids as $bid) {
            Transaction::factory()->create([
                'bid_id' => $bid->id, 
                'user_id' => $bid->participant->user_id,
                'amount_final' => $bid->amount
            ]);
        }
    }
}
