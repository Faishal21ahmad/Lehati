<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'ishal',
            'email' => 'faisal2017bahi@gmail.com',
            'role' => 'administrator',
        ]);

        for ($i = 1; $i <= 2; $i++) {
            User::factory()->create([
                'name' => 'ishal' . $i,
                'email' => 'ishal' . $i . '@example.com',
                'role' => 'admin',
            ]);
        }

        for ($i = 1; $i <= 4; $i++) {
            User::factory()->create([
                'name' => 'galuh' . $i,
                'email' => 'galuh' . $i . '@example.com',
                'role' => 'auctioneer',
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            User::factory()->create([
                'name' => 'miftah' . $i,
                'email' => 'miftah' . $i . '@example.com',
                'role' => 'bidder',
            ]);
        }
    }
}
