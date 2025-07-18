<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        UserData::create([
            'user_id' => $users->first()->id,
            'phone' => '082100000000',
            'address' => 'Jl. Magelang No. 1',
            'nik' => '1234567890123456',
            'gender' => 'female',
            'bank' => 'BRI',
            'bank_name' => 'GALUH',
            'bank_number' => '54344323523235',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (array_slice($users->toArray(), 1) as $user) {
            UserData::factory()->create([
                'user_id' => $user['id'],
                'phone' => '082100000000',
                'address' => 'Jl. Contoh Alamat No. ' . ($user['id']),
            ]);
        }
    }
}
