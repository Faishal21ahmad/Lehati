<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID');
        $productDescriptions = [
            'Produk segar langsung dari kebun petani lokal.',
            'Dipanen pada pagi hari untuk menjaga kesegaran maksimal.',
            'Bebas pestisida dan bahan kimia berbahaya.',
            'Sangat cocok untuk konsumsi harian maupun usaha kuliner.',
            'Telah melalui proses sortir untuk kualitas terbaik.',
            'Dikemas secara higienis dan siap kirim.',
            'Rasa manis alami dan tekstur yang renyah.',
            'Cocok untuk dijadikan bahan olahan makanan sehat.',
            'Tersedia dalam jumlah terbatas sesuai musim panen.',
            'Sudah dipercaya oleh banyak pelanggan dan mitra pasar.'
        ];

        return [
            'product_name' => $this->faker->randomElement([
                'Rawit Merah',
                'Rawit Hijau',
                'Rawit Putih',
                'Rawit Domba',
                'Rawit Lado',
                'Rawit Pelita',
                'Rawit Ungu',
                'Rawit Kencana',
                'Rawit Sakura',
                'Rawit Supernova',
                'Merah Besar',
                'Hijau Besar',
                'Keriting Merah',
                'Keriting Hijau',
                'Gendot',
                'Katokkon',
                'Lembang',
                'Madura',
                'Bara',
                'Bara Api',
                'TM Merah',
                'TM 999',
                'Teja',
                'Tanjung Api',
                'Cakra Hijau',
                'Panah Merah',
                'Halilintar',
                'Pelita 8 F1',
                'Lado F1',
                'Bima Sakti',
                'Segitiga',
                'Red Thunder',
                'Ajaib',
                'Golden Flame',
                'Nirmala',
                'Andalas',
                'Darajat',
                'Pelangi',
                'Ungu Violet',
                'Hijau Botol',
            ]),

            'description' => $faker->randomElement($productDescriptions),
            'quantity' => $this->faker->numberBetween(1, 100),
            'units' => $this->faker->randomElement(['kg', 'ton', 'ons', 'kuintal']),
            'status' => $this->faker->randomElement(['available', 'use', 'sold']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
