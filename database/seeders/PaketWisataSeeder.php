<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketWisata;

class PaketWisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaketWisata::create([
            'title' => 'Coffee Plantation Glamping Experience',
            'description' => 'Rasakan pengalaman glamping di kebun kopi Pupuan...',
            'price' => 850000,
            'max_person' => 2,
            'location' => 'Pupuan, Tabanan',
            'duration' => '2D1N',
            'main_image' => 'coffee_main.jpg',
            'gallery' => ['coffee1.jpg', 'coffee2.jpg', 'coffee3.jpg', 'coffee4.jpg', 'coffee5.jpg', 'coffee6.jpg'],
            'fasilitas' => ['1 tenda glamping','2 kasur angin','2 sleeping bag','2 bantal','Sarapan pagi','Coffee cupping session'],
            'category' => "glamping"
        ]);

    }
}
