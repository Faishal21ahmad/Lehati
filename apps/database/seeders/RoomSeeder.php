<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsAvailable = Product::where('status', 'available')->get();
        $productsUse = Product::where('status', 'use')->get();
        $productsSold = Product::where('status', 'sold')->get();

        $timenow = Carbon::now();


        foreach ($productsUse->values() as $index => $product) {
            $status = $index % 2 === 0 ? 'upcoming' : 'ongoing';

            Room::factory()->create([
                'user_id' => 1,
                'product_id' => $product->id,
                'status' => $status,
                'start_time' => $status === 'upcoming'
                    ? $timenow->copy()->addDays(rand(1, 3))
                    : $timenow->copy()->subDays(rand(1, 2)),
                'end_time' => $timenow->copy()->addDays(rand(2, 4)),
            ]);
        }


        foreach ($productsSold as $product) {
            Room::factory()->create([
                'user_id' => 1,
                'product_id' => $product->id,
                'status' => 'ended',
                'start_time' => $timenow->copy()->subDays(5),
                'end_time' => $timenow->copy()->subDays(4),
            ]);
        }

        // Available
        $cancelledRooms = $productsAvailable->take(5);
        foreach ($cancelledRooms as $product) {
            Room::factory()->create([
                'user_id' => 1,
                'product_id' => $product->id,
                'status' => 'cancelled',
                'start_time' => $timenow->copy()->subDays(rand(2, 5)),
                'end_time' => $timenow->copy()->addDays(rand(1, 3)),
            ]);
        }
    }
}


// // Tambah 15 hari
// $plus15days = $timenow->copy()->addDays(15);

// // Tambah 15 bulan
// $plus15months = $timenow->copy()->addMonths(15);

// // Tambah 15 tahun
// $plus15years = $timenow->copy()->addYears(15);


// // Kurangi 15 hari
// $minus15days = $timenow->copy()->subDays(15);

// // Kurangi 15 bulan
// $minus15months = $timenow->copy()->subMonths(15);

// // Kurangi 15 tahun
// $minus15years = $timenow->copy()->subYears(15);