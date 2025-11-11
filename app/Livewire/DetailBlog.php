<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Article;
use Illuminate\Support\Facades\Session;


class DetailBlog extends Component
{
    #[Layout('layouts.app')]

    public $blog;
    public $relatedBlogs;
    public $lang;
    public $texts = [];

    public function mount($slug)
    {
        $this->blog = Article::where('status', 'published')
            ->where('slug', $slug)
            ->with('author')
            ->first();

        // If not found, redirect to articles page
        if (!$this->blog) {
            session()->flash('error', 'Artikel tidak ditemukan atau belum dipublikasi.');
            return redirect()->route('article');
        }

        // Increment views
        $this->blog->increment('views');

        // Get 6 latest blogs except current one
        $this->relatedBlogs = Article::where('status', 'published')
            ->where('id', '!=', $this->blog->id)
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();
    }
    private function setTexts()
    {
        $this->texts = [
            'article_detail' => __('messages.article_detail'),
            'article_title' => __('messages.article_title'),
            'article_description' => __('messages.article_description'),
            'article_type' => __('messages.article_type'),
        ];
    }


    public function render()
    {
        return view('livewire.detail-blog');
    }
}
