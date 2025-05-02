<?php

namespace App\Livewire\Partials;

use Livewire\Attributes\On;
use Livewire\Component;

class NavButton extends Component
{

    public string $text;
    public $route;
    public $collapsed;

    public ?int $badge = null;


    public ?string $icon = null;
    public ?string $logo = null;

    public bool $beta = false;

    #[On('sidebar-toggle')]
    public function toggle()
    {
        $this->collapsed = !$this->collapsed;
    }

    public function render()
    {
        return view('livewire.partials.nav-button');
    }
}
