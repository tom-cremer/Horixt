<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AssignedToMe extends HorixtComponent
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
