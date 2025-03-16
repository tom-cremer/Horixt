<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{

    public $collapsed;

    public function mount()
    {

        $this->collapsed = session('sidebar_collapsed', false);
    }

    public function toggle()
    {
        $this->collapsed = !$this->collapsed;
        session(['sidebar_collapsed' => $this->collapsed]);
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
