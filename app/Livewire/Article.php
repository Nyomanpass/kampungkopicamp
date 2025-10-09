<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Blog;

class Article extends Component
{
    #[Layout('layouts.app')]
    public $blogs;

    // Saat component dimount
    public function mount()
    {
        // Ambil semua blog, urut dari tanggal published terbaru
        $this->blogs = Blog::orderBy('published_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.article', [
            'blogs' => $this->blogs
        ]);
    }
}
