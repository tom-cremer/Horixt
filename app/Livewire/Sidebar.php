<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;

class Sidebar extends HorixtComponent
{
    #[Session(key: 'collapsed')]
    public $collapsed = false;

    public $organizations = [];

    public function mount()
    {
        $this->organizations = auth()->user()->organizations;
    }

    public function toggle()
    {
        $this->dispatch('sidebar-toggle');
        return $this->collapsed = !$this->collapsed;
    }

    #[On('organization-created')]
    public function getOrganizations()
    {
        $this->organizations = auth()->user()->organizations;
    }

    public function render()
    {
        $collapsed = $this->collapsed;
        return view('livewire.sidebar', compact('collapsed'));
    }
}
