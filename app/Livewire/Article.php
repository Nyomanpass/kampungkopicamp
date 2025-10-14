<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Blog;
use Illuminate\Support\Facades\Session;

class Article extends Component
{

    public $lang;
    public $texts = [];

    public function mount()
    {
        $this->lang = Session::get('locale', 'id');
        $this->setTexts();
        $this->blogs = Blog::orderBy('published_at', 'desc')->get();
    }

        private function setTexts()
    {
        $this->texts = [
            'articles_stories' => __('messages.articles_stories'),
            'explore_inspiration' => __('messages.explore_inspiration'),
            'explore_description' => __('messages.explore_description'),
            'latest_news_events' => __('messages.latest_news_events'),
            'latest_stories_heading' => __('messages.latest_stories_heading'),
            'latest_stories_description' => __('messages.latest_stories_description'),
            'article_type' => __('messages.article_type'),
        ];
    }


        public function setLang($lang)
    {
        Session::put('locale', $lang);
        $this->lang = $lang;
        $this->setTexts();
    }

    #[Layout('layouts.app')]
    public $blogs;

    // Saat component dimount
 

    public function render()
    {
        return view('livewire.article', [
            'blogs' => $this->blogs
        ]);
    }
}
