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
            'name' => 'Galuh 1',
            'email' => 'galuhmiftakhurahman@students.amikom.ac.id',
            'role' => 'admin',
        ]);

        for ($i = 1; $i <= 15; $i++) {
            User::factory()->create([
                'name' => 'miftah' . $i,
                'email' => 'miftah' . $i . '@example.com',
                'role' => 'bidder',
            ]);
        }
    }
}
