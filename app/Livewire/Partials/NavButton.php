<?php

namespace App\Livewire\Partials;

use App\Livewire\Component\HorixtComponent;
use Livewire\Attributes\On;
use Livewire\Component;

class NavButton extends HorixtComponent
{

    public string $text;
    public $route;
    public $collapsed;

    public ?int $badge = null;


    public ?string $icon = null;
    public ?string $logo = null;

    public bool $beta = false;

    public function mount(string $text, string $route, ?string $icon = null, ?string $logo = null, ?int $badge = null, bool $beta = false)
    {
        $this->text = $text;
        $this->route = $route;
        $this->icon = $icon;
        $this->logo = $logo;
        $this->badge = $badge;
        $this->beta = $beta;

        // Initialize collapsed state from session
        if (session()->has('collapsed')) {
            $this->collapsed = session('collapsed');
        } else {
            $this->collapsed = false; // Default value
        }
    }
    #[On('sidebar-toggle')]
    public function toggle()
    {
        $this->collapsed = session('collapsed') ?? false;
    }

    public function render()
    {
        return view('livewire.partials.nav-button');
    }
}
