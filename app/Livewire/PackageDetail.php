<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Product;

class PackageDetail extends Component
{
    #[Layout('components.layouts.detailProduct')]


    public $product;
    public $selectedImage = null;
    public $startDate;
    public $endDate;
    public $peopleCount = 1;


    public function mount($slug)
    {
        $this->product = Product::with('availability')->where('slug', $slug)->firstOrFail();

        // Set default selected image (main image atau first dari gallery)
        if (!empty($this->product->images) && is_array($this->product->images)) {
            $this->selectedImage = $this->product->images[0];
        }
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
