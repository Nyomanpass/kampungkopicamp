<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Navbar extends Component
{
    public $lang;
    public $texts = [];
    public $mobileMenuOpen = false; // toggle mobile menu
    public $scrolled = false; //

    public function mount()
    {
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();
    }

    private function setTexts()
    {
        $this->texts = __('messages');
    }


    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

  

    public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts(); // update teks jika menggunakan translation
    }

    public function render()
    {
        return view('livewire.layout.navbar');
    }
}
