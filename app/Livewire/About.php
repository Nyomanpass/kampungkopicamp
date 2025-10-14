<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;

class About extends Component
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
            'journey_heading' => __('messages.journey_heading'),
            'journey_description' => __('messages.journey_description'),
            'journey' => [
                [
                    'year' => '2018',
                    'title' => __('messages.journey_2018_title'),
                    'desc' => __('messages.journey_2018_desc'),
                ],
                [
                    'year' => '2019',
                    'title' => __('messages.journey_2019_title'),
                    'desc' => __('messages.journey_2019_desc'),
                ],
                [
                    'year' => '2020',
                    'title' => __('messages.journey_2020_title'),
                    'desc' => __('messages.journey_2020_desc'),
                ],
                [
                    'year' => '2021',
                    'title' => __('messages.journey_2021_title'),
                    'desc' => __('messages.journey_2021_desc'),
                ],
                [
                    'year' => '2022',
                    'title' => __('messages.journey_2022_title'),
                    'desc' => __('messages.journey_2022_desc'),
                ],
            ],
            'gallery_heading' => __('messages.gallery_heading'),
            'gallery_description' => __('messages.gallery_description'),

            'testimonial_heading' => __('messages.testimonial_heading'),
            'testimonial_description' => __('messages.testimonial_description'),

            'testimonials' => [
                [
                    'quote' => __('messages.testimonial1_quote'),
                    'name' => __('messages.testimonial1_name'),
                    'role' => __('messages.testimonial1_role'),
                ],
                [
                    'quote' => __('messages.testimonial2_quote'),
                    'name' => __('messages.testimonial2_name'),
                    'role' => __('messages.testimonial2_role'),
                ],
                [
                    'quote' => __('messages.testimonial3_quote'),
                    'name' => __('messages.testimonial3_name'),
                    'role' => __('messages.testimonial3_role'),
                ],
            ],



            'whatsapp_heading' => __('messages.whatsapp_heading'),
            'whatsapp_description' => __('messages.whatsapp_description'),
            'whatsapp_number' => __('messages.whatsapp_number'),
            'phone_heading' => __('messages.phone_heading'),
            'phone_number' => __('messages.phone_number'),
            'email_heading' => __('messages.email_heading'),
            'email_address' => __('messages.email_address'),
            'address_heading' => __('messages.address_heading'),
            'address_details' => __('messages.address_details'),
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
