<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\PaketWisata as PaketWisataModel;

class PaketWisata extends Component
{
    // Properti untuk menyimpan ID kategori yang sedang aktif/dipilih
    public string $activeCategory = 'all';

    // Data Dummy Kategori
    public array $categories = [
        ['id' => 'all', 'name' => 'Semua Paket', 'icon' => 'fa-solid fa-layer-group'],
        ['id' => 'glamping', 'name' => 'Glamping & Tenda', 'icon' => 'fa-solid fa-campground'],
        ['id' => 'activity', 'name' => 'Aktivitas', 'icon' => 'fa-solid fa-person-running'],
    ];


    /**
     * Fungsi yang dipanggil dari Blade untuk mengubah kategori aktif
     */
    public function filterPackages(string $categoryId): void
    {
        $this->activeCategory = $categoryId;
    }

    /**
     * Menghitung produk yang ditampilkan berdasarkan kategori aktif (Computed Property)
     */
    #[Computed]
    public function filteredProducts()
    {
        if ($this->activeCategory === 'all') {
            return PaketWisataModel::all();
        }

        return PaketWisataModel::where('category', $this->activeCategory)->get();
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.paketwisata');
    }
}
