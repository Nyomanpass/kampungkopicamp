<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addons = [
            [
                'name' => 'Kayu Bakar',
                'pricing_type' => 'per_unit_per_night',
                'price' => 25000,
                'description' => 'Satu ikat kayu bakar untuk kebutuhan api unggun per malam.',
                'image' => 'kayuBakar.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'BBQ Set',
                'pricing_type' => 'per_booking',
                'price' => 100000,
                'description' => 'Paket peminjaman peralatan BBQ (grill, arang, penjepit, piring, dan meja).',
                'image' => 'bbqSet.jpeg',
                'is_active' => true,
            ],
            [
                'name' => 'Sarapan Pagi',
                'pricing_type' => 'per_person',
                'price' => 30000,
                'description' => 'Sarapan lengkap (nasi goreng, kopi/teh) untuk setiap tamu per pagi.',
                "image" => 'buburSumsum.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Sewa Sepeda Gunung',
                'pricing_type' => 'per_hour',
                'price' => 20000,
                'description' => 'Sewa sepeda gunung per jam untuk menjelajah area sekitar camping.',
                'image' => 'sepedaGunung.jpeg',
                'is_active' => true,
            ],
        ];

        foreach ($addons as $addon) {
            Addon::updateOrCreate(['name' => $addon['name']], $addon);
        }

        $this->command->info('Add-on dummy data seeded successfully.');
    }
}
