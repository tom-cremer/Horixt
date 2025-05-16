<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use Livewire\Component;

class Dashboard extends HorixtComponent
{


    public function mount()
    {
    }

    public function render()
    {
        return view('dashboard');
    }
}
