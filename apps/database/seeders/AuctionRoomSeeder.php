<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\AuctionRoom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuctionRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            AuctionRoom::factory()->create([
                'auctioneer_id' => $product->auctioneer_id,
                'product_id' => $product->id
            ]);
        }
    }
}
