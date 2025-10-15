<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PaketWisata;
use App\Models\Blog;
use Illuminate\Support\Facades\Session;


class Home extends Component
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
            'badge' => __('messages.badge'),
            'headline_part1' => __('messages.headline_part1'),
            'headline_part2' => __('messages.headline_part2'),
            'subheadline' => __('messages.subheadline'),
            'happy_travelers' => __('messages.happy_travelers'),
            'location' => __('messages.location'),
            'cta_packages' => __('messages.cta_packages'),
            'cta_booking' => __('messages.cta_booking'),
            'about_badge' => __('messages.about_badge'),
            'about_title_part1' => __('messages.about_title_part1'),
            'about_title_part2' => __('messages.about_title_part2'),
            'about_desc1' => __('messages.about_desc1'),
            'about_desc2' => __('messages.about_desc2'),
            'feature_coffee_title' => __('messages.feature_coffee_title'),
            'feature_coffee_desc' => __('messages.feature_coffee_desc'),
            'feature_nature_title' => __('messages.feature_nature_title'),
            'feature_nature_desc' => __('messages.feature_nature_desc'),
            'learn_more' => __('messages.learn_more'),
            'organic' => __('messages.organic'),
            'support' => __('messages.support'),
            'explore_title' => __('messages.explore_title'),
            'explore_heading' => __('messages.explore_heading'),
            'explore_description' => __('messages.explore_description'),
            'dest_air_terjun' => __('messages.dest_air_terjun'),
            'dest_air_terjun_time' => __('messages.dest_air_terjun_time'),
            'dest_air_terjun_desc' => __('messages.dest_air_terjun_desc'),
            'dest_jatiluwih' => __('messages.dest_jatiluwih'),
            'dest_jatiluwih_time' => __('messages.dest_jatiluwih_time'),
            'dest_jatiluwih_desc' => __('messages.dest_jatiluwih_desc'),
            'dest_kopi' => __('messages.dest_kopi'),
            'dest_kopi_time' => __('messages.dest_kopi_time'),
            'dest_kopi_desc' => __('messages.dest_kopi_desc'),
            'dest_desa' => __('messages.dest_desa'),
            'dest_desa_time' => __('messages.dest_desa_time'),
            'dest_desa_desc' => __('messages.dest_desa_desc'),
            'stat_destinasi' => __('messages.stat_destinasi'),
            'stat_rating' => __('messages.stat_rating'),
            'stat_experience' => __('messages.stat_experience'),
            'heading' => __('messages.about_heading'),
            'description' => __('messages.about_description'),
            'cta_text' => __('messages.about_cta'),
            'gallery_heading' => __('messages.gallery_heading'),
            'gallery_description' => __('messages.gallery_description'),
            'contact_heading' => __('messages.contact_heading'),
            'contact_description' => __('messages.contact_description'),

            'paket_heading' => __('messages.popular_packages_heading'),
            'paket_description' => __('messages.popular_packages_description'),
            'tombol_booking'   => __('messages.tombol_booking'),
            'tombol_detail'   => __('messages.tombol_detail'),
            'mak_person'       => __('messages.mak_person'),
            'fasilitas'        => __('messages.fasilitas'),


            'article_heading' => __('messages.latest_articles_heading'),
            'article_description' => __('messages.latest_articles_description'),
            'article_type' => __('messages.article_type'),

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
        $pakets = \App\Models\Products::oldest()->take(3)->get();
        $blogs = Blog::latest()->take(3)->get();
        return view('livewire.home', [
            'pakets' => $pakets,
            "blogs" => $blogs
        ]);
    }
}
