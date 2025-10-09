<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Blog;

class ArticleDetail extends Component
{
    public $blog;
    public $relatedBlogs;

    public function mount($slug)
    {
        // Ubah slug menjadi title (misal: kampung-kopi-camp → kampung kopi camp)
        $title = str_replace('-', ' ', $slug);

        // Ambil blog beserta semua kontennya
        $this->blog = Blog::with('contents')
                          ->where('title', 'LIKE', '%' . $title . '%')
                          ->firstOrFail();

        // Ambil 5 blog terbaru selain yang dibuka, beserta konten pertama tiap blog
        $this->relatedBlogs = Blog::with('contents')
                                  ->where('id', '!=', $this->blog->id)
                                  ->orderBy('published_at', 'desc')
                                  ->take(5)
                                  ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.article-detail', [
            'blog' => $this->blog,
            'relatedBlogs' => $this->relatedBlogs,
        ]);
    }
}
