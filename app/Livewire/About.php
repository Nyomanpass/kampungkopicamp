<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use App\Models\SiteSetting;

class About extends Component
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
        $this->texts = [
            'small' => __('messages.about_hero_small'),
            'heading' => __('messages.about_hero_heading'),
            'description' => __('messages.about_hero_description'),
            'about_small' => __('messages.about_highlight_small'),
            'about_heading' => __('messages.about_highlight_heading'),
            'about_description' => __('messages.about_highlight_description'),
            'story_small' => __('messages.about_story_small'),
            'story_heading' => __('messages.about_story_heading'),
            'story_subheading' => __('messages.about_story_subheading'),
            'story_paragraph1' => __('messages.about_story_paragraph1'),
            'story_paragraph2' => __('messages.about_story_paragraph2'),
            'value_heading' => __('messages.value_heading'),
            'value_description' => __('messages.value_description'),
            'value_card1_title' => __('messages.value_card1_title'),
            'value_card1_desc' => __('messages.value_card1_desc'),
            'value_card2_title' => __('messages.value_card2_title'),
            'value_card2_desc' => __('messages.value_card2_desc'),
            'value_card3_title' => __('messages.value_card3_title'),
            'value_card3_desc' => __('messages.value_card3_desc'),
            'value_card4_title' => __('messages.value_card4_title'),
            'value_card4_desc' => __('messages.value_card4_desc'),
            
            'gallery_heading' => __('messages.gallery_heading'),
            'gallery_description' => __('messages.gallery_description'),

            'uniqueness_heading' => __('messages.uniqueness_heading'),
            'uniqueness_description' => __('messages.uniqueness_desc'),
            'uniqueness_p1' => __('messages.uniqueness_p1'),
            'uniqueness_p2' => __('messages.uniqueness_p2'),
            'uniqueness_p3' => __('messages.uniqueness_p3'),
            
            'whatsapp_heading' => __('messages.whatsapp_heading'),
            'whatsapp_description' => __('messages.whatsapp_description'),
            'whatsapp_number' => $this->contactInfo['phone'] ?: __('messages.whatsapp_number'),
            'phone_heading' => __('messages.phone_heading'),
            'phone_number' => $this->contactInfo['phone'] ?: __('messages.phone_number'),
            'email_heading' => __('messages.email_heading'),
            'email_address' => $this->contactInfo['email'] ?: __('messages.email_address'),
            'address_heading' => __('messages.address_heading'),
            'address_details' => $this->contactInfo['address'] ?: __('messages.address_details'),
            'address_map_cta' => __('messages.address_map_cta'),
            'location_heading' => __('messages.location_heading'),

        ];
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
        return view('livewire.about');
    }
}
