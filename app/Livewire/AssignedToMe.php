<?php

namespace App\Livewire;

use App\Helper\Context;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AssignedToMe extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $projects;

    public function mount(): void
    {
    }

    public function render()
    {
        $this->projects = Context::getOrganization()->projects;
        return view('livewire.assigned-to-me');
    }
}
