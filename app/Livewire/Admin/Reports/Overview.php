<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Overview extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.reports.overview');
    }
}
