<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(10)->create([
            'user_id' => 1,
            'status' => 'available'
        ]);
        Product::factory(40)->create([
            'user_id' => 1,
            'units' => 'ton',
            'status' => 'use'
        ]);
        Product::factory(2)->create([
            'user_id' => 1,
            'units' => 'kuintal',
            'status' => 'sold'
        ]);
    }
}
