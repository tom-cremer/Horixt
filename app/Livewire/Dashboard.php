<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    public $colors;

    public function mount()
    {
        $this->colors = \App\Models\Color::all();
    }

    public function render()
    {
        return view('dashboard');
    }
}
