<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'banners',
                'value' => [],
                'description' => 'Banner carousel untuk dashboard user',
                'is_active' => true,
            ],
            [
                'key' => 'contact_info',
                'value' => [
                    'whatsapp' => '6281234567890',
                    'email' => 'info@kampungkopicamp.com',
                    'phone' => '+62 812-3456-7890',
                    'address' => 'Jl. Pupuan, Tabanan, Bali',
                ],
                'description' => 'Informasi kontak website',
                'is_active' => true,
            ],
            [
                'key' => 'google_maps',
                'value' => [
                    'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.604370894168!2d115.03691309999999!3d-8.342048799999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd229a2ecb99547%3A0x8a1a833f13b4a85b!2sKampung%20Kopi%20Camp!5e0!3m2!1sid!2sid!4v1760613519348!5m2!1sid!2sid',
                ],
                'description' => 'Google Maps embed link untuk lokasi',
                'is_active' => true,
            ],
            [
                'key' => 'social_media',
                'value' => [
                    'facebook' => '',
                    'instagram' => '',
                    'tiktok' => '',
                    'youtube' => '',
                ],
                'description' => 'Link media sosial',
                'is_active' => true,
            ],
            [
                'key' => 'faqs',
                'value' => [
                    [
                        'id' => 1,
                        'question' => 'Apakah bisa refund?',
                        'answer' => 'Ya, refund dapat dilakukan maksimal 7 hari sebelum tanggal check-in dengan potongan biaya administrasi 10%.',
                        'order' => 1,
                    ],
                    [
                        'id' => 2,
                        'question' => 'Berapa minimal booking?',
                        'answer' => 'Minimal booking adalah 1 hari untuk paket camping dan 2 orang untuk paket touring.',
                        'order' => 2,
                    ],
                    [
                        'id' => 3,
                        'question' => 'Apakah tersedia fasilitas parkir?',
                        'answer' => 'Ya, kami menyediakan area parkir gratis untuk semua tamu yang menginap.',
                        'order' => 3,
                    ],
                ],
                'description' => 'Frequently Asked Questions',
                'is_active' => true,
            ],
            [
                'key' => 'house_rules',
                'value' => [
                    [
                        'id' => 1,
                        'title' => 'Prosedur Check-in',
                        'content' => 'Check-in dimulai dari pukul 14:00 WIB. Tamu wajib menunjukkan ID Card dan booking confirmation. Pembayaran pelunasan dapat dilakukan di front desk jika belum lunas.',
                        'order' => 1,
                    ],
                    [
                        'id' => 2,
                        'title' => 'Kebijakan Pembatalan',
                        'content' => 'Pembatalan dapat dilakukan maksimal 7 hari sebelum check-in untuk mendapatkan refund 90%. Pembatalan kurang dari 7 hari akan dikenakan biaya pembatalan 50%.',
                        'order' => 2,
                    ],
                    [
                        'id' => 3,
                        'title' => 'Aturan Berkemah',
                        'content' => 'Dilarang membuat api unggun di luar area yang telah ditentukan. Harap menjaga kebersihan area camping dan membuang sampah pada tempatnya. Waktu tenang dimulai pukul 22:00 WIB.',
                        'order' => 3,
                    ],
                ],
                'description' => 'Peraturan dan kebijakan tempat',
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
