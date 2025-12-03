<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use App\Models\SiteSetting;

class TermsOfService extends Component
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
                  'tiktok' => '',
                  'youtube' => '',
                  'facebook' => '',
                  'instagram' => '',
            ]);
      }

      private function setTexts()
      {
            $this->texts = [

                  'address' => $this->contactInfo['address'] ?: __('messages.privacy_section10_email'),
                  'phone' => $this->contactInfo['phone'] ?: __('messages.privacy_section10_phone'),
                  'email' => $this->contactInfo['email'] ?: __('messages.privacy_section10_email'),

            ];
      }

      public function setLang($lang)
      {
            Session::put('locale', $lang);
            $this->lang = $lang;
            $this->setTexts(); // update teks jika menggunakan translation
      }

      #[Layout('layouts.app')]
      public function render()
      {
            return view('livewire.terms-of-service');
      }
}
