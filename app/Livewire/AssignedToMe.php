<?php

namespace App\Livewire;

use App\Helper\Context;
use Livewire\Component;

class AssignedToMe extends Component
{
    public $projects;

    public function mount(): void
    {
        $this->projects = Context::getOrganization()->projects;
    }

    public function render()
    {
        return view('livewire.assigned-to-me');
    }
}
