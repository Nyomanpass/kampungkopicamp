<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use App\Models\SiteSetting;

class Contact extends Component

{

    public $lang;
    public $texts = [];
    public $contactInfo = [];
    public $socialMedia = [];
    public $gmaps = [];

    public function mount()
    {
        $this->lang = Session::get('locale', 'id');
        $this->loadSettings();
        $this->setTexts();
    }

    private function loadSettings()
    {
        // Load Contact Info
        $this->contactInfo = SiteSetting::get('contact_info', [
            'whatsapp' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
        ]);

        // Load Social Media
        $this->socialMedia = SiteSetting::get('social_media', [
            'tiktok' => '',
            'youtube' => '',
            'facebook' => '',
            'instagram' => '',
        ]);

        $this->gmaps = SiteSetting::get('google_maps', [
            'embed_url' => '',
        ]);
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
