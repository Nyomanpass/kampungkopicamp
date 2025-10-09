<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PaketWisata;
use Illuminate\Support\Str;

class PaketDetail extends Component
{
    public $paket;

    public function mount($slug)
    {
        // Ubah slug jadi judul (contoh: coffee-plantation → coffee plantation)
        $title = str_replace('-', ' ', $slug);

        // Cari berdasarkan title yang mirip
        $this->paket = PaketWisata::where('title', 'LIKE', '%' . $title . '%')->firstOrFail();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.paket-detail', [
            'paket' => $this->paket
        ]);
    }
}
