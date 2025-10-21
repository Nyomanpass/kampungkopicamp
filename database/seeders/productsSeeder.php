<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Glamping Standar Package',
            'type' => 'accommodation',
            'price' => 250000,
            'capacity_per_unit' => 3,
            'duration_type' => 'daily',
            'images' => json_encode(['glamping1.jpg', 'glamping2.jpg', 'glamping3.jpg', 'glamping4.jpg']),
            'facilities' => json_encode(['WiFi Gratis', 'AC', 'Sarapan', 'Kamar Mandi Dalam', 'Pemanas Air']),
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Tenda Standar Package',
            'type' => 'accommodation',
            'price' => 100000,
            'capacity_per_unit' => 2,
            'duration_type' => 'daily',
            'images' => json_encode(['glampingB1.jpg', 'glampingB2.jpg', 'glampingB3.jpg', 'glampingB4.jpg']),
            'facilities' => json_encode(['WiFi Gratis', '2 Sleeping Bag', '2 Kasur Angin', '2 Bantal']),
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Kebun Kopi Tour',
            'type' => 'touring',
            'price' => 300000,
            'max_participant' => 10,
            'duration_type' => 'multi_day',
            'images' => json_encode(['touring1.jpg', 'touring2.jpg', 'touring3.jpg']),
            'facilities' => json_encode(['Transportasi', 'Makan Siang', 'Guide']),
            'is_active' => true,
        ]);
    }
}
