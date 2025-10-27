<?php

namespace App\Livewire\ExplorePupuan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;

class RoastingKopi extends Component
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
            'sudah_siap_jelajah' => __('messages.sudah_siap_jelajah'),
            'pupuan' => __('messages.pupuan'),
            'pilih_paket' => __('messages.pilih_paket'),
            'lihat_paket' => __('messages.lihat_paket'),
        ];
         $this->texts = __('messages');
    }

    public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts();
    }

        #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.explore-pupuan.roasting-kopi');
    }
}
