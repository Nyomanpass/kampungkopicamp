<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Session;

class PackageDetail extends Component
{
    #[Layout('components.layouts.detailProduct')]

    public $lang;
    public $texts = [];

    public $product;
    public $selectedImage = null;
    public $startDate;
    public $endDate;
    public $peopleCount = 1;
    public $googleMaps = [];
    public $faqs = [];
    public $houseRules = [];


    public function mount($slug)
    {
        $this->lang = Session::get('locale', 'id');
    
        app()->setLocale($this->lang);
        
        
        $this->product = Product::with('availability')->where('slug', $slug)->firstOrFail();

        // Set default selected image (main image atau first dari gallery)
        if (!empty($this->product->images) && is_array($this->product->images)) {
            $this->selectedImage = $this->product->images[0];
        }

        // Load settings
        $this->loadSettings();
    }

    public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        
        // Update locale Laravel secara runtime
        app()->setLocale($lang);
    }

    private function loadSettings()
    {
        $this->googleMaps = SiteSetting::get('google_maps', [
            'embed_url' => '',
        ]);

        $this->faqs = SiteSetting::get('faqs', []);
        $this->houseRules = SiteSetting::get('house_rules', []);
    }

    public function selectImage($image)
    {
        $this->selectedImage = $image;
    }

    public function relatedPackages()
    {
        return Product::where('id', '!=', $this->product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.package-detail', [
            'relatedPackages' => $this->relatedPackages()
        ]);
    }
}
