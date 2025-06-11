<?php

namespace App\Livewire\Partials;

use App\Helper\Context;
use Livewire\Attributes\On;
use Livewire\Component;

class OrganizationSelect extends Component
{

    public $collapsed;

    public $organizations = [];
    public $selectedOrganization = null;

    public function mount($collapsed)
    {

        $this->collapsed = $collapsed;
        $this->organizations = auth()->user()->organizations;
        $this->selectedOrganization = Context::isOrganization()
            ? Context::getOrganization()
            : auth()->user();
    }

    #[On('sidebar-toggle')]
    public function toggle()
    {
        $this->collapsed = !$this->collapsed;
    }

    public function render()
    {
        return view('livewire.partials.organization-select');
    }
}
