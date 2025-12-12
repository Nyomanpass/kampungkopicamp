<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use App\Models\SiteSetting;

class Contact extends Component
{
    public $nama;
    public $email;
    public $telepon;
    public $subjek;
    public $pesan;

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
        // Data ini otomatis terambil dari SiteSetting
        $this->contactInfo = SiteSetting::get('contact_info', [
            'whatsapp' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
        ]);

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

   public function sendWhatsApp()
    {
        
        $number = $this->contactInfo['whatsapp'];  

        if (!$number) {
            dd('Nomor WhatsApp tidak ditemukan di database');
        }
        $number = preg_replace('/\D/', '', $number);

        $text =
            "Nama: {$this->nama}\n" .
            "Email: {$this->email}\n" .
            "Telepon: {$this->telepon}\n" .
            "Subjek: {$this->subjek}\n" .
            "Pesan: {$this->pesan}";


        $url = "https://wa.me/{$number}?text=" . urlencode($text);

        $this->dispatch('open-wa', url: $url);
    }



    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.contact');
    }
}
