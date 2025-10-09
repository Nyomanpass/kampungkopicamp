<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Contact extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.contact');
    }
}
