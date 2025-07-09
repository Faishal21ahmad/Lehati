<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID');
        $roomNotesList = [
            'Ruang lelang akan dibuka 10 menit sebelum waktu mulai.',
            'Harap pastikan koneksi internet stabil selama sesi lelang.',
            'Peserta diwajibkan membaca syarat dan ketentuan sebelum mulai.',
            'Penawaran tertinggi otomatis ditampilkan secara real-time.',
            'Lelang ini bersifat publik dan terbuka untuk semua pengguna.',
            'Ruang ini hanya untuk produk hasil pertanian segar.',
            'Sesi lelang akan berakhir otomatis sesuai waktu yang ditentukan.',
            'Pastikan Anda sudah login sebelum mengikuti lelang.',
            'Admin akan memantau jalannya lelang secara langsung.',
            'Catatan: tidak ada biaya tambahan untuk bergabung di ruang ini.'
        ];

        $startTime = $this->faker->dateTimeBetween('now', '+1 week');
        $endTime = $this->faker->dateTimeBetween($startTime, '+2 weeks');

        return [
            'room_code' => 'RM' . $this->faker->unique()->numberBetween(1000, 9999),
            'room_notes' => $faker->randomElement($roomNotesList),
            'status' => $this->faker->randomElement(['upcoming', 'ongoing', 'ended', 'cancelled']),
            'starting_price' => $this->faker->numberBetween(10000, 50000000),
            'min_bid_step' => $this->faker->numberBetween(1000, 50000),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
