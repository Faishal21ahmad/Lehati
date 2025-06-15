<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ImageProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            ImageProduct::factory(4)->create([
                'product_id' => $product->id
            ]);
        }
    }
}
