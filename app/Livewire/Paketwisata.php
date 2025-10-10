<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\PaketWisata as PaketWisataModel;
use App\Models\Category;

class PaketWisata extends Component
{
    public string $activeCategory = 'all';
    public array $categories = []; // nanti diisi dari database

    public function mount()
    {
        // Ambil kategori dari database
        $this->categories = Category::all()->toArray();
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
