<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Session; // KRUSIAL: Impor Session


class AdminSidebar extends Component
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
            'dashboard' => __('messages.dashboard'),
            'paket_wisata' => __('messages.paket_wisata'),
            'artikel' => __('messages.artikel'),
            'category' => __('messages.category'),
            'kontak' => __('messages.kontak'),
            'logout' => __('messages.logout'),
        ];
    }



    public function render()
    {
        return view('livewire.layout.admin-sidebar');
    }
}
