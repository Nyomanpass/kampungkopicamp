<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\PaketWisata as PaketWisataModel;
use App\Models\Category;
use Illuminate\Support\Facades\Session;


class PaketWisata extends Component
{
    public string $activeCategory = 'all';
    public $categories;
    public $lang;
    public $texts = [];
        

    public function mount()
    {
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();
        $this->categories = Category::all(); // aman
        $this->lang = session('locale', 'id'); // default bahasa
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


        protected $listeners = [
            'languageChanged' => 'updateLang'
        ];

        public function updateLang($payload)
        {
            $this->lang = $payload['lang'] ?? 'id';
        }

    // Mengubah kategori aktif
    public function filterPackages(string $categoryId): void
    {
        $this->activeCategory = $categoryId;
        $this->dispatch('scroll-to-paket');
    }

    // Computed property untuk paket wisata
    #[Computed]
    public function filteredProducts()
    {
        if ($this->activeCategory === 'all') {
            return PaketWisataModel::all();
        }

        return PaketWisataModel::where('category_id', $this->activeCategory)->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        
        return view('livewire.paketwisata', [
            'filteredProducts' => $this->filteredProducts,
            'categories' => $this->categories,
        ]);
    }

}
