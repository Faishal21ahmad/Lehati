<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\AuctioneerData;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auctioneers = AuctioneerData::all();

        foreach ($auctioneers as $auctioneer) {
            Product::factory()->create([
                'auctioneer_id' => $auctioneer->id
            ]);
        }
    }
}
