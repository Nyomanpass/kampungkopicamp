<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PaketWisata;
use Illuminate\Support\Facades\Session;

class PaketDetail extends Component
{
    public $paket;
    public $lang;
    public $texts = [];

    public function mount($slug)
    {
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();
        $this->lang = session('locale', 'id'); // default bahasa
        // Ubah slug jadi judul (contoh: coffee-plantation → coffee plantation)
        $title = str_replace('-', ' ', $slug);

        // Cari berdasarkan title yang mirip
        $this->paket = PaketWisata::where('title', 'LIKE', '%' . $title . '%')->firstOrFail();
    }


     private function setTexts()
    {
        $this->texts = [
            'subheading' => __('messages.paket_hero_subheading'),
            'title' => __('messages.paket_hero_title'),
            'description' => __('messages.paket_hero_description'),
            'filter_paket' => __('messages.filter_category'),
            'how_to_order_heading' => __('messages.how_to_order_heading'),
            'how_to_order_description' => __('messages.how_to_order_description'),
            'how_to_order_steps' => [
                [
                    'title' => __('messages.step1_title'),
                    'desc'  => __('messages.step1_desc')
                ],
                [
                    'title' => __('messages.step2_title'),
                    'desc'  => __('messages.step2_desc')
                ],
                [
                    'title' => __('messages.step3_title'),
                    'desc'  => __('messages.step3_desc')
                ],
                [
                    'title' => __('messages.step4_title'),
                    'desc'  => __('messages.step4_desc')
                ],
                [
                    'title' => __('messages.step5_title'),
                    'desc'  => __('messages.step5_desc')
                ],
            ],

            'custom_package_heading' => __('messages.custom_package_heading'),
            'custom_package_description' => __('messages.custom_package_description'),
            'custom_package_button' => __('messages.custom_package_button'),

            'mak_person'       => __('messages.mak_person'),
            'tombol_booking'   => __('messages.tombol_booking'),
            'about_paket' => __('messages.paket_about'),
            'fasilitas_dua' => __('messages.fasilitas_dua'),
            'reservation_confirmation_title' => __('messages.reservation_confirmation_title'),
            'checkin_time' => __('messages.checkin_time'),
            'checkout_time' => __('messages.checkout_time'),
            'show_reservation_proof' => __('messages.show_reservation_proof'),
            'detail_paket_subheading'   => __('messages.detail_paket_subheading'),
            'detail_paket_title'        => __('messages.detail_paket_title'),
            'detail_paket_description'  => __('messages.detail_paket_description'),


        ];
    }


        public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts();
    }


        protected $listeners = [
            'languageChanged' => 'updateLang'
        ];

        public function updateLang($payload)
        {
            $this->lang = $payload['lang'] ?? 'id';
        }



    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.paket-detail', [
            'paket' => $this->paket
        ]);
    }
}
