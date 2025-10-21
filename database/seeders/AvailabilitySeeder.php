<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Availability;
use Carbon\Carbon;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $today = Carbon::today();
        $endDate = $today->copy()->addDays(60); // 2 bulan ke depan
        $products = [
            ['id' => 1, 'available_unit' => 20],
            ['id' => 2, 'available_unit' => 20],
            ['id' => 3, 'available_unit' => 20],
        ];

        foreach ($products as $product) {
            $date = $today->copy();

            while ($date->lte($endDate)) {
                Availability::updateOrCreate(
                    [
                        'product_id' => $product['id'],
                        'date' => $date->toDateString(),
                    ],
                    [
                        'available_unit' => $product['available_unit'],
                    ]
                );

                $date->addDay();
            }
        }

        $this->command->info('Availability data seeded successfully for 2 months ahead.');
    }
}
