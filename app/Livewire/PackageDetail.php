<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Product;
use App\Models\SiteSetting;

class PackageDetail extends Component
{
    #[Layout('components.layouts.detailProduct')]


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
        $this->product = Product::with('availability')->where('slug', $slug)->firstOrFail();

        // Set default selected image (main image atau first dari gallery)
        if (!empty($this->product->images) && is_array($this->product->images)) {
            $this->selectedImage = $this->product->images[0];
        }

        // Load settings
        $this->loadSettings();
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
