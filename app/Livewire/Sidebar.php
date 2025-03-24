<?php

namespace App\Livewire;

use Livewire\Attributes\Session;
use Livewire\Component;

class Sidebar extends Component
{
    #[Session]
    public $collapsed = false;

    public function toggle()
    {
        return $this->collapsed = !$this->collapsed;
    }

    public function render()
    {
        $collapsed = $this->collapsed;
        return view('livewire.sidebar', compact('collapsed'));
    }
}
