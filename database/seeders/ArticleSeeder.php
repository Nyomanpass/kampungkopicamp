<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $articles = [
            [
                'title' => '10 Tips Wisata Hemat ke Bali',
                'slug' => '10-tips-wisata-hemat-ke-bali',
                'excerpt' => 'Nikmati keindahan Bali tanpa menguras kantong dengan tips hemat ini.',
                'content' => '<h2>Pendahuluan</h2><p>Bali adalah destinasi wisata favorit di Indonesia. Dengan perencanaan yang tepat, Anda bisa menikmati keindahan Bali dengan budget terbatas.</p><h2>Tips Hemat</h2><ol><li>Pilih waktu kunjungan di luar musim ramai</li><li>Gunakan transportasi umum atau rental motor</li><li>Makan di warung lokal</li><li>Booking hotel atau villa jauh-jauh hari</li><li>Manfaatkan voucher dan promo</li></ol>',
                'category' => 'tips',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
                'views' => 1250,
                'meta_description' => 'Panduan lengkap wisata hemat ke Bali dengan tips praktis untuk menghemat budget perjalanan Anda.',
                'author_id' => $admin->id,
            ],
            [
                'title' => 'Jelajahi Keindahan Pupuan, Tabanan',
                'slug' => 'jelajahi-keindahan-pupuan-tabanan',
                'excerpt' => 'Pupuan menawarkan pemandangan sawah berundak yang memukau dan udara sejuk pegunungan.',
                'content' => '<h2>Tentang Pupuan</h2><p>Pupuan adalah sebuah desa di Kabupaten Tabanan yang terkenal dengan pemandangan sawah berundag yang indah dan perkebunan kopi.</p><h2>Daya Tarik</h2><ul><li>Sawah berundak yang hijau</li><li>Perkebunan kopi arabika</li><li>Udara sejuk pegunungan</li><li>Pemandangan sunset yang menakjubkan</li></ul>',
                'category' => 'destinasi',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'views' => 890,
                'meta_description' => 'Pupuan Tabanan menawarkan keindahan sawah berundak dan perkebunan kopi yang wajib dikunjungi.',
                'author_id' => $admin->id,
            ],
            [
                'title' => 'Kuliner Khas Bali yang Wajib Dicoba',
                'slug' => 'kuliner-khas-bali-yang-wajib-dicoba',
                'excerpt' => 'Dari babi guling hingga lawar, ini dia kuliner khas Bali yang akan memanjakan lidah Anda.',
                'content' => '<h2>Kuliner Khas Bali</h2><p>Bali tidak hanya terkenal dengan keindahan alamnya, tapi juga kekayaan kulinernya yang unik dan lezat.</p><h2>Rekomendasi Makanan</h2><ol><li><strong>Babi Guling</strong> - Ikon kuliner Bali</li><li><strong>Lawar</strong> - Campuran sayur dan daging cincang</li><li><strong>Sate Lilit</strong> - Sate khas dengan bumbu merata</li><li><strong>Bebek Betutu</strong> - Bebek dengan bumbu khas Bali</li><li><strong>Nasi Jinggo</strong> - Nasi bungkus mini khas Bali</li></ol>',
                'category' => 'kuliner',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
                'views' => 670,
                'meta_description' => 'Panduan lengkap kuliner khas Bali dari babi guling hingga lawar yang wajib Anda coba.',
                'author_id' => $admin->id,
            ],
            [
                'title' => 'Mengenal Budaya Tri Hita Karana di Bali',
                'slug' => 'mengenal-budaya-tri-hita-karana-di-bali',
                'excerpt' => 'Tri Hita Karana adalah filosofi hidup masyarakat Bali yang harmonis.',
                'content' => '<h2>Filosofi Tri Hita Karana</h2><p>Tri Hita Karana adalah konsep keseimbangan hidup dalam budaya Bali yang terdiri dari tiga hubungan harmonis.</p><h2>Tiga Pilar Utama</h2><ol><li><strong>Parahyangan</strong> - Hubungan harmonis dengan Tuhan</li><li><strong>Pawongan</strong> - Hubungan harmonis antar sesama manusia</li><li><strong>Palemahan</strong> - Hubungan harmonis dengan alam</li></ol><p>Filosofi ini tercermin dalam kehidupan sehari-hari masyarakat Bali.</p>',
                'category' => 'budaya',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(7),
                'views' => 450,
                'meta_description' => 'Pelajari filosofi Tri Hita Karana yang menjadi dasar kehidupan harmonis masyarakat Bali.',
                'author_id' => $admin->id,
            ],
            [
                'title' => 'Persiapan Liburan ke Bali: Checklist Lengkap',
                'slug' => 'persiapan-liburan-ke-bali-checklist-lengkap',
                'excerpt' => 'Checklist lengkap apa saja yang perlu disiapkan sebelum liburan ke Bali.',
                'content' => '<h2>Persiapan Sebelum Berangkat</h2><p>Liburan yang menyenangkan dimulai dari persiapan yang matang. Berikut checklist yang perlu Anda siapkan.</p><h2>Dokumen Penting</h2><ul><li>KTP / Passport</li><li>Tiket pesawat / bus</li><li>Voucher hotel</li><li>Asuransi perjalanan</li></ul><h2>Barang Bawaan</h2><ul><li>Pakaian sesuai cuaca</li><li>Obat-obatan pribadi</li><li>Sunblock dan kacamata hitam</li><li>Kamera dan powerbank</li></ul>',
                'category' => 'tips',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
                'views' => 0,
                'meta_description' => 'Checklist persiapan lengkap sebelum liburan ke Bali agar perjalanan Anda lancar.',
                'author_id' => $admin->id,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
