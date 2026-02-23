<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class PackageCard extends Component
{
    public $product;
    public $lang;


    public function mount($product)
    {
        $this->product = $product;
        $this->lang = Session::get('locale', 'id');
    }

    public function render()
    {
        return view('livewire.package-card');
    }
}
