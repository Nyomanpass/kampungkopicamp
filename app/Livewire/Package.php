<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;

class Package extends Component
{
    #[Layout('layouts.app')]

    public $accommodationProducts = [];
    public $touringProducts = [];
    public $areaProducts = [];

    public function mount()
    {
        $this->loadProducts();
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
