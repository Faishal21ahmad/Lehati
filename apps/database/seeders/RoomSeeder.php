<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            Room::factory()->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id
            ]);
        }
    }
}
