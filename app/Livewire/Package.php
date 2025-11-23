<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Package extends Component
{
    #[Layout('layouts.app')]

    public $accommodationProducts = [];
    public $touringProducts = [];
    public $areaProducts = [];
    public $lang;
    public $texts = [];

    public function mount()
    {
        $this->loadProducts();
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();
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
            
            'tombol_booking'   => __('messages.tombol_booking'),
            'tombol_detail'   => __('messages.tombol_detail'),
            'mak_person'       => __('messages.mak_person'),
            'fasilitas'        => __('messages.fasilitas'),
            'about_paket' => __('messages.paket_about'),

        ];
    }

    public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts();
    }
    

    public function loadProducts()
    {
        // Load Accommodation Products (Camping)
        $this->accommodationProducts = Product::where('is_active', true)
            ->where('type', 'accommodation')
            ->orderBy('created_at', 'desc')
            ->get();

        // Load Touring Products
        $this->touringProducts = Product::where('is_active', true)
            ->where('type', 'touring')
            ->orderBy('created_at', 'desc')
            ->get();

        // Load Area Products (Rekreasi)
        $this->areaProducts = Product::where('is_active', true)
            ->where('type', 'area')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.package');
    }
}
