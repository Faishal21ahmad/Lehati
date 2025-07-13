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
        // $products = Product::all();

        $timenow = Carbon::now();

        Room::factory()->create([
            'user_id' => 1,
            'product_id' => 1,
            'status' => 'cancelled',
            'start_time' => $timenow->copy()->subDays(3),
            'end_time' => $timenow->copy()->addDays(2)
        ]);
        Room::factory()->create([
            'user_id' => 1,
            'product_id' => 2,
            'status' => 'upcoming',
            'start_time' => $timenow->copy()->addDays(4),
            'end_time' => $timenow->copy()->addDays(7)
        ]);
        Room::factory()->create([
            'user_id' => 1,
            'product_id' => 3,
            'status' => 'ongoing',
            'start_time' => $timenow->copy()->subDays(2),
            'end_time' => $timenow->copy()->addDays(2),
        ]);
        Room::factory()->create([
            'user_id' => 1,
            'product_id' => 4,
            'status' => 'ended',
            'start_time' => $timenow->copy()->subDays(5),
            'end_time' => $timenow->copy()->subDays(4),
        ]);
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