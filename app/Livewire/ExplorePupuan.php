<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;

class ExplorePupuan extends Component
{   
    public $lang;
    public $texts = [];

    public function mount()
    {
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();
    }

     private function setTexts()
    {
        $this->texts = [
            'small' => __('messages.hero_pupuan_small'),        // Alam & Budaya Bali
            'heading' => __('messages.hero_pupuan_heading'),    // Jelajahi Pesona Pupuan
            'highlight' => __('messages.hero_pupuan_highlight'),// Pupuan (jika ingin dipisah warnanya)
            'description' => __('messages.hero_pupuan_desc'),   // Nikmati keindahan al
            'about_explore_small' => __('messages.about_explore_small'),
            'about_explore_heading' => __('messages.about_explore_heading'),
            'about_explore_highlight' => __('messages.about_explore_highlight'),
            'about_explore_heading_suffix' => __('messages.about_explore_heading_suffix'),
            'about_explore_paragraph1' => __('messages.about_explore_paragraph1'),
            'about_explore_paragraph2' => __('messages.about_explore_paragraph2'),
            'why_explore_title' => __('messages.why_explore_title'),
            'why_explore_desc'  => __('messages.why_explore_desc'),
            'card1_title' => __('messages.card1_title'),
            'card1_desc'  => __('messages.card1_desc'),
            'card2_title' => __('messages.card2_title'),
            'card2_desc'  => __('messages.card2_desc'),
            'card3_title' => __('messages.card3_title'),
            'card3_desc'  => __('messages.card3_desc'),
            'card4_title' => __('messages.card4_title'),
            'card4_desc'  => __('messages.card4_desc'),

            'lihat_detail' => __('messages.visit_view_detail'),

            'gallery_heading' => __('messages.gallery_heading'),
            'gallery_description' => __('messages.gallery_description'),

            'headline' => [
                'title' => __('messages.visit_title'),
                'desc'  => __('messages.visit_desc'),
            ],

            'cards' => [
                [
                    'image' => '/images/airterjunpupuanblemantung.webp',
                    'link' => '/explore-pupuan/airterjun',
                    'title' => __('messages.visit_card1_title'),
                    'desc'  => __('messages.visit_card1_desc'),
                ],
                [
                    'image' => '/images/durianpupuan.jpg',
                    'link' => '/explore-pupuan/durian-pupuan',
                    'title' => __('messages.visit_card2_title'),
                    'desc'  => __('messages.visit_card2_desc'),
                ],
                [
                    'image' => '/images/explorepupuansatu.webp',
                    'link' => '/explore-pupuan/patuhbudha',
                    'title' => __('messages.visit_card3_title'),
                    'desc'  => __('messages.visit_card3_desc'),
                ],
                [
                    'image' => '/images/gulaarenpupuan.jpg',
                    'link' => '/explore-pupuan/gulaaren',
                    'title' => __('messages.visit_card4_title'),
                    'desc'  => __('messages.visit_card4_desc'),
                ],
                [
                    'image' => '/images/teraseringpupuan.jpg',
                    'link' => '/explore-pupuan/terasering-sawah',
                    'title' => __('messages.visit_card5_title'),
                    'desc'  => __('messages.visit_card5_desc'),
                ],
                [
                    'image' => '/images/kopipupuan.webp',
                    'link' => '/explore-pupuan/roasting-kopi',
                    'title' => __('messages.visit_card6_title'),
                    'desc'  => __('messages.visit_card6_desc'),
                ],
            ],

            'tips_headline' => [
            'title' => __('messages.tips_title'),
            'desc'  => __('messages.tips_desc'),
            ],

            'tips_cards' => [
                [
                    'icon' => 'fa-clock',
                    'title' => __('messages.tips_card1_title'),
                    'desc'  => __('messages.tips_card1_desc'),
                ],
                [
                    'icon' => 'fa-map-signs',
                    'title' => __('messages.tips_card2_title'),
                    'desc'  => __('messages.tips_card2_desc'),
                ],
                [
                    'icon' => 'fa-shoe-prints',
                    'title' => __('messages.tips_card3_title'),
                    'desc'  => __('messages.tips_card3_desc'),
                ],
            ],


            'sudah_siap_jelajah' => __('messages.sudah_siap_jelajah'),
            'pupuan' => __('messages.pupuan'),
            'pilih_paket' => __('messages.pilih_paket'),
            'lihat_paket' => __('messages.lihat_paket'),


        ];
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
        return view('livewire.explore-pupuan');
    }
}
