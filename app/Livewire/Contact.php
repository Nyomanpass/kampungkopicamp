<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;

class Contact extends Component

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
        return view('livewire.contact');
    }
}
