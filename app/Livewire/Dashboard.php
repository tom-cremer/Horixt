<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;

class Dashboard extends HorixtComponent
{


    public function mount()
    {
    }

    public function setTimezone($timezone)
    {
        session()->put('timezone', $timezone);
    }

    public function render()
    {
        return view('dashboard');
    }
}
