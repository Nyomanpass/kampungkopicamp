<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\SiteSetting;

class Footer extends Component
{

    public $lang;
    public $texts = [];
    public $contactInfo = [];
    public $socialMedia = [];

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
            'facebook' => '',
            'instagram' => '',
            'tiktok' => '',
            'youtube' => '',
        ]);
    }

    private function setTexts()
    {
        $this->texts = [
            'brand' => __('messages.footer_brand'),
            'desc' => __('messages.footer_desc'),
            'quick_links' => __('messages.footer_quick_links'),
            'contact' => __('messages.footer_contact'),
            'address' => $this->contactInfo['address'] ?: __('messages.footer_address'),
            'phone' => $this->contactInfo['phone'] ?: __('messages.footer_phone'),
            'email' => $this->contactInfo['email'] ?: __('messages.footer_email'),
            'open_hours' => __('messages.footer_open_hours'),
            'hours_weekdays' => __('messages.footer_hours_weekdays'),
            'hours_weekend' => __('messages.footer_hours_weekend'),
            'hours_holiday' => __('messages.footer_hours_holiday'),
            'copyright' => __('messages.footer_copyright'),
            'privacy' => __('messages.footer_privacy'),
            'terms' => __('messages.footer_terms'),
        ];
    }

    public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts(); // update teks jika menggunakan translation
    }


    public function render()
    {
        return view('livewire.layout.footer');
    }
}
