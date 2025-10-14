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
        $this->texts = [
            'home' => __('messages.home'),
            'about' => __('messages.about'),
            'tour_packages' => __('messages.tour_packages'),
            'explore_pupuan' => __('messages.explore_pupuan'),
            'article' => __('messages.article'),
            'contact' => __('messages.contact'),
            'booking_now' => __('messages.booking_now'),
            'login' => __('messages.login'),
            'bahasa' => __('messages.bahasa'),
        ];
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
