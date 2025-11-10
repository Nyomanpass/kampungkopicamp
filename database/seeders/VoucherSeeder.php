<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers =  [
            [
                'code' => 'WELCOME10',
                'name' => 'Diskon Pengguna Baru',
                'type' => 'percentage',
                'value' => 10,
                'min_order' => 0,
                'max_discount' => 50000,
                'usage_limit' => 100,
                'used_count' => 0,
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addMonths(1),
                'is_active' => true,
                'description' => 'Diskon 10% khusus untuk pengguna baru. Maksimum potongan Rp50.000.',
                'show_in_dashboard' => true,
            ],
            [
                'code' => 'WEEKEND50K',
                'name' => 'Voucher Akhir Pekan',
                'type' => 'fixed',
                'value' => 50000,
                'min_order' => 300000,
                'max_discount' => null,
                'usage_limit' => 50,
                'used_count' => 0,
                'start_date' => Carbon::now()->subDay(),
                'end_date' => Carbon::now()->addDays(10),
                'is_active' => true,
                'description' => 'Potongan langsung Rp50.000 untuk minimal transaksi Rp300.000 selama akhir pekan.',
                'show_in_dashboard' => true,
            ],
            [
                'code' => 'CAMPFEST2025',
                'name' => 'Event Camp Fest 2025',
                'type' => 'percentage',
                'value' => 20,
                'min_order' => 0,
                'max_discount' => 100000,
                'usage_limit' => 200,
                'used_count' => 0,
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true,
                'description' => 'Diskon 20% dalam rangka acara Camp Fest 2025! Berlaku mulai minggu depan.',
                'show_in_dashboard' => true,
            ],
            [
                'code' => 'EXPIREDTEST',
                'name' => 'Voucher Kadaluarsa',
                'type' => 'fixed',
                'value' => 25000,
                'min_order' => 100000,
                'max_discount' => null,
                'usage_limit' => 10,
                'used_count' => 0,
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->subDays(5),
                'is_active' => false,
                'description' => 'Contoh voucher kadaluarsa untuk testing validasi tanggal.',
                'show_in_dashboard' => false,
            ],
            [
                'code' => 'LIMITED5',
                'name' => 'Voucher Terbatas 5x Pakai',
                'type' => 'percentage',
                'value' => 15,
                'min_order' => 0,
                'max_discount' => 30000,
                'usage_limit' => 5,
                'used_count' => 2,
                'start_date' => Carbon::now()->subDay(),
                'end_date' => Carbon::now()->addDays(15),
                'is_active' => true,
                'description' => 'Diskon 15% hanya untuk 5 pemakaian pertama.',
                'show_in_dashboard' => true,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::updateOrCreate(['code' => $voucher['code']], $voucher);
        }

        $this->command->info('Voucher dummy data seeded successfully.');
    }
}
