<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Sidebar extends Component
{
    public $collapsed;

    public function mount()
    {
        $this->collapsed = Session::get('sidebar_collapsed', false);
    }

    public function toggle()
    {
        $this->collapsed = !$this->collapsed;
        Session::put('sidebar_collapsed', $this->collapsed);
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
