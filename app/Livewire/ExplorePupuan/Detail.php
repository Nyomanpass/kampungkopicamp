<?php

namespace App\Livewire\ExplorePupuan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;

class Detail extends Component
{
    public $slug;
    public $data;
    public $lang;
    public $texts = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();

        $datas = [

            // =====================================================
            // 🟦 AIR TERJUN BLEMANTUNG
            // =====================================================
            'air-terjun-blemantung' => [
                'header_image' => '/images/airterjunpupuanblemantung.webp',
                'header_category' => __('messages.blematung_header_category'),
                'header_title' => __('messages.blematung_header_title'),
                'header_subtitle' => __('messages.blematung_header_subtitle'),

                // --- Why Special ---
                'why_special_title' => __('messages.why_special_title'),
                'specials' => [
                    [
                        'icon' => 'fa-mountain',
                        'title' => __('messages.special_1_title'),
                        'desc'  => __('messages.special_1_desc'),
                    ],
                    [
                        'icon' => 'fa-coffee',
                        'title' => __('messages.special_2_title'),
                        'desc'  => __('messages.special_2_desc'),
                    ],
                    [
                        'icon' => 'fa-snowflake',
                        'title' => __('messages.special_3_title'),
                        'desc'  => __('messages.special_3_desc'),
                    ],
                    [
                        'icon' => 'fa-water',
                        'title' => __('messages.special_4_title'),
                        'desc'  => __('messages.special_4_desc'),
                    ],
                ],

                // --- Quote ---
                'quote_text' => __('messages.quote_blematung_text'),
                'quote_source' => __('messages.quote_blematung_source'),

                // --- Trekking Section ---
                'trekking_title' => __('messages.trekking_title'),

                'trekking_medan_title' => __('messages.trekking_medan_title'),
                'trekking_medan_desc'  => __('messages.trekking_medan_desc'),

                'trekking_difficulty_title' => __('messages.trekking_difficulty_title'),
                'trekking_difficulty_desc'  => __('messages.trekking_difficulty_desc'),

                'trekking_time_title' => __('messages.trekking_time_title'),
                'trekking_time_desc'  => __('messages.trekking_time_desc'),

                'trekking_view_title' => __('messages.trekking_view_title'),
                'trekking_view_desc'  => __('messages.trekking_view_desc'),

                // --- Persiapan Wajib ---
                'persiapan_wajib_title' => __('messages.persiapan_wajib_title'),
                'persiapan' => [
                    __('messages.wajib_1_desc'),
                    __('messages.wajib_2_desc'),
                    __('messages.wajib_3_desc'),
                    __('messages.wajib_4_desc'),
                ]
            ],

            'durian-pupuan' => [
                'header_image' => '/images/durianpupuan.jpg',
                'header_category' => __('messages.tagline_agro'),
                'header_title' => __('messages.title_durian'),
                'header_subtitle' => __('messages.subtitle_durian'),

                // --- Why Special ---
                'why_special_title' => __('messages.section_title_durian'),
                'specials' => [
                    [
                        'icon' => 'fa-seedling',
                        'title' => __('messages.point1_title_durian'),
                        'desc'  => __('messages.point1_desc_durian'),
                    ],
                    [
                        'icon' => 'fa-leaf',
                        'title' => __('messages.point2_title_durian'),
                        'desc'  => __('messages.point2_desc_durian'),
                    ],
                    [
                        'icon' => 'fa-hand-holding-water',
                        'title' => __('messages.point3_title_durian'),
                        'desc'  => __('messages.point3_desc_durian'),
                    ],
                    [
                        'icon' => 'fa-tree',
                        'title' => __('messages.point4_title_durian'),
                        'desc'  => __('messages.point4_desc_durian'),
                    ],
                ],

                // --- Quote ---
                'quote_text' => __('messages.durian_quote'),
                'quote_source' => 'Petani Lokal Pupuan',

                // --- Trekking Section (diganti jadi edukasi durian tapi tetap ikut struktur lama) ---
                'trekking_title' => __('messages.durian_step_title'),

                // karena template butuh 4 bagian trekking, kita isi sesuai tema durian
                'trekking_medan_title' => __('messages.durian_step1_title'),
                'trekking_medan_desc'  => __('messages.durian_step1_desc'),

                'trekking_difficulty_title' => __('messages.durian_step2_title'),
                'trekking_difficulty_desc'  => __('messages.durian_step2_item1'),

                'trekking_time_title' => __('messages.durian_step_time_title'),
                'trekking_time_desc'  => __('messages.durian_step_time_desc'),

                'trekking_view_title' => __('messages.durian_step_view_title'),
                'trekking_view_desc'  => __('messages.durian_step_view_desc'),

                // --- Persiapan (disesuaikan tema durian) ---
                'persiapan_wajib_title' => __('messages.durian_persiapan_title'),
                'persiapan' => [
                    __('messages.durian_persiapan_1'),
                    __('messages.durian_persiapan_2'),
                    __('messages.durian_persiapan_3'),
                    __('messages.durian_persiapan_4'),
                ],
            ],

            'buddha-tidur' => [
                'header_image' => '/images/headerexplorepupuan.webp',
                'header_category' => __('messages.buddha_location'),
                'header_title' => __('messages.buddha_title'),
                'header_subtitle' => __('messages.buddha_description'),

                // --- Why Special ---
                'why_special_title' => __('messages.vihara_why_title'),
                'specials' => [
                    [
                        'icon' => 'fa-spa', // icon bisa diganti sesuai selera
                        'title' => __('messages.vihara_poin1_title'),
                        'desc'  => __('messages.vihara_poin1_desc'),
                    ],
                    [
                        'icon' => 'fa-bed',
                        'title' => __('messages.vihara_poin2_title'),
                        'desc'  => __('messages.vihara_poin2_desc'),
                    ],
                    [
                        'icon' => 'fa-leaf',
                        'title' => __('messages.vihara_poin3_title'),
                        'desc'  => __('messages.vihara_poin3_desc'),
                    ],
                    [
                        'icon' => 'fa-place-of-worship',
                        'title' => __('messages.vihara_poin4_title'),
                        'desc'  => __('messages.vihara_poin4_desc'),
                    ],
                ],

                // --- Quote Section ---
                'quote_text' => __('messages.giri_desc_quote'),
                'quote_source' => 'Vihara Dharma Giri',

                // --- Trekking Section (Diganti jadi Panduan Kunjungan) ---
                'trekking_title' => __('messages.guide_title'),

                'trekking_medan_title' => __('messages.akses_judul'),
                'trekking_medan_desc'  => __('messages.akses_deskripsi'),

                'trekking_difficulty_title' => __('messages.lokasi_tepat'),
                'trekking_difficulty_desc'  => __('messages.lokasi_tepat_desc'),

                'trekking_time_title' => __('messages.petunjuk_arah'),
                'trekking_time_desc'  => __('messages.petunjuk_arah_desc'),

                'trekking_view_title' => __('messages.dapat_dilihat'),
                'trekking_view_desc'  => __('messages.dapat_dilihat_desc'),

                // --- Persiapan / Etika ---
                'persiapan_wajib_title' => __('messages.etika_judul'),
                'persiapan' => [
                    __('messages.etika1'),
                    __('messages.etika2'),
                    __('messages.etika3'),
                    __('messages.etika4'),
                ],
            ],

            'gula-aren' => [
                'header_image' => '/images/gulaarenpupuan.jpg',
                'header_category' => __('messages.tagline_agro'),
                'header_title' => __('messages.gula_hero_title'),
                'header_subtitle' => __('messages.gula_hero_desc'),

                // --- Why Special ---
                'why_special_title' => __('messages.gula_judul_section'),
                'specials' => [
                    [
                        'icon' => 'fa-hammer',
                        'title' => __('messages.gula_poin1_judul'),
                        'desc'  => __('messages.gula_poin1_text'),
                    ],
                    [
                        'icon' => 'fa-leaf',
                        'title' => __('messages.gula_poin2_judul'),
                        'desc'  => __('messages.gula_poin2_text'),
                    ],
                    [
                        'icon' => 'fa-fire',
                        'title' => __('messages.gula_poin3_judul'),
                        'desc'  => __('messages.gula_poin3_text'),
                    ],
                    [
                        'icon' => 'fa-box',
                        'title' => __('messages.gula_poin4_judul'),
                        'desc'  => __('messages.gula_poin4_text'),
                    ],
                ],

                // --- Quote ---
                'quote_text' => __('messages.gula_quote_desc'),
                'quote_source' => 'Petani Gula Aren Pupuan',

                // --- Trekking Section (disesuaikan menjadi proses produksi) ---
                'trekking_title' => __('messages.gula_proses_section_title'),

                'trekking_medan_title' => __('messages.gula_proses1_title'),
                'trekking_medan_desc'  => __('messages.gula_proses1_desc'),

                'trekking_difficulty_title' => __('messages.gula_proses1_target_title'),
                'trekking_difficulty_desc'  => __('messages.gula_proses1_target_text'),

                'trekking_time_title' => __('messages.gula_proses1_teknik_title'),
                'trekking_time_desc'  => __('messages.gula_proses1_teknik_text'),

                'trekking_view_title' => __('messages.gula_proses1_durasi_title'),
                'trekking_view_desc'  => __('messages.gula_proses1_durasi_text'),

                // --- Persiapan (Edukasi proses) ---
                'persiapan_wajib_title' => __('messages.gula_proses2_title'),
                'persiapan' => [
                    __('messages.gula_proses2_poin1'),
                    __('messages.gula_proses2_poin2'),
                    __('messages.gula_proses2_poin3'),
                    __('messages.gula_proses2_poin4'),
                ],
            ],

            'terasering-sawah' => [
                'header_image' => '/images/teraseringpupuan.jpg',
                'header_category' => __('messages.tagline_agro'),
                'header_title' => __('messages.terassering_title'),
                'header_subtitle' => __('messages.terassering_desc'),

                // --- Why Special ---
                'why_special_title' => __('messages.belimbing_section_title'),
                'specials' => [
                    [
                        'icon' => 'fa-mountain',
                        'title' => __('messages.belimbing_poin1_judul'),
                        'desc'  => __('messages.belimbing_poin1_desc'),
                    ],
                    [
                        'icon' => 'fa-tree',
                        'title' => __('messages.belimbing_poin2_judul'),
                        'desc'  => __('messages.belimbing_poin2_desc'),
                    ],
                    [
                        'icon' => 'fa-water',
                        'title' => __('messages.belimbing_poin3_judul'),
                        'desc'  => __('messages.belimbing_poin3_desc'),
                    ],
                    [
                        'icon' => 'fa-person-hiking',
                        'title' => __('messages.belimbing_poin4_judul'),
                        'desc'  => __('messages.belimbing_poin4_desc'),
                    ],
                ],

                // --- Quote ---
                'quote_text' => __('messages.trekking_quote'),
                'quote_source' => 'Wisatawan Belimbing',

                // --- Trekking Section ---
                'trekking_title' => __('messages.trekking_section_title'),

                'trekking_medan_title' => __('messages.trekking_card1_title'),
                'trekking_medan_desc'  => __('messages.trekking_card1_desc'),

                'trekking_difficulty_title' => __('messages.trekking_trekking_title'),
                'trekking_difficulty_desc'  => __('messages.trekking_trekking_desc'),

                'trekking_time_title' => __('messages.trekking_cycling_title'),
                'trekking_time_desc'  => __('messages.trekking_cycling_desc'),

                'trekking_view_title' => __('messages.trekking_waterfall_title'),
                'trekking_view_desc'  => __('messages.trekking_waterfall_desc'),

                // --- Persiapan / Etika di Sawah ---
                'persiapan_wajib_title' => __('messages.trekking_card2_title'),
                'persiapan' => [
                    __('messages.trekking_etika1'),
                    __('messages.trekking_etika2'),
                    __('messages.trekking_etika3'),
                    __('messages.trekking_etika4'),
                ],
            ],

            'roasting-kopi' => [

                // --- HEADER ---
                'header_image' => '/images/kopipupuan.webp',
                'header_category' => __('messages.kopi_subtitle'),
                'header_title' => __('messages.kopi_judul'),
                'header_subtitle' => __('messages.kopi_deskripsi'),

                // --- KEISTIMEWAAN / WHY SPECIAL ---
                'why_special_title' => __('messages.kopi_keistimewaan_judul'),
                'specials' => [
                    [
                        'icon' => 'fa-seedling',
                        'title' => __('messages.kopi_poin1_judul'),
                        'desc'  => __('messages.kopi_poin1_desc'),
                    ],
                    [
                        'icon' => 'fa-mug-hot',
                        'title' => __('messages.kopi_poin2_judul'),
                        'desc'  => __('messages.kopi_poin2_desc'),
                    ],
                    [
                        'icon' => 'fa-fire',
                        'title' => __('messages.kopi_poin3_judul'),
                        'desc'  => __('messages.kopi_poin3_desc'),
                    ],
                    [
                        'icon' => 'fa-leaf',
                        'title' => __('messages.kopi_poin4_judul'),
                        'desc'  => __('messages.kopi_poin4_desc'),
                    ],
                ],

                // --- QUOTE ---
                'quote_text' => __('messages.kopi_quote'),
                'quote_source' => 'Petani Kopi Pupuan',

                // --- PROSES (MENGIKUTI TEMPLATE TREKKING) ---
                'trekking_title' => __('messages.kopi_panduan_judul'),

                'trekking_medan_title' => __('messages.kopi_panen_judul'),
                'trekking_medan_desc'  => __('messages.kopi_panen_desc'),

                'trekking_difficulty_title' => __('messages.kopi_pemetikan_judul'),
                'trekking_difficulty_desc'  => __('messages.kopi_pemetikan_desc'),

                'trekking_time_title' => __('messages.kopi_penjemuran_judul'),
                'trekking_time_desc'  => __('messages.kopi_penjemuran_desc'),

                'trekking_view_title' => __('messages.kopi_pengeringan_judul'),
                'trekking_view_desc'  => __('messages.kopi_pengeringan_desc'),

                // --- PERSIAPAN / PROSES ROASTING ---
                'persiapan_wajib_title' => __('messages.kopi_roasting_judul'),
                'persiapan' => [
                    __('messages.kopi_roasting_poin1'),
                    __('messages.kopi_roasting_poin2'),
                    __('messages.kopi_roasting_poin3'),
                    __('messages.kopi_roasting_poin4'),
                ],
            ],







            // =====================================================
            // Destinasi lain nanti tinggal tambah di sini:
            // 'durian-pupuan' => [...]
            // 'patung-budha-tidur' => [...]
            // =====================================================
        ];

        // Cek slug
        $this->data = $datas[$slug] ?? abort(404);
    }

    public function setTexts()
    {
         $this->texts = [
            'sudah_siap_jelajah' => __('messages.sudah_siap_jelajah'),
            'pupuan' => __('messages.pupuan'),
            'pilih_paket' => __('messages.pilih_paket'),
            'lihat_paket' => __('messages.lihat_paket'),
        ];

        $this->texts = __('messages');
        app()->setLocale($this->lang);
    }

    public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts();
    }
    

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.explore-pupuan.detail');
    }
}
