<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PaketWisata;
use App\Models\Blog;


class Home extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {   
        $pakets = PaketWisata::oldest()->take(3)->get();
        $blogs = Blog::latest()->take(3)->get();
        return view('livewire.home', [
            'pakets' => $pakets,
            "blogs" => $blogs
        ]);
    }
}
