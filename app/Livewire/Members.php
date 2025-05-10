<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Models\Organization;
use Flux\Concerns\InteractsWithComponents;
use Flux\Flux;
use Livewire\Component;

class Members extends Component
{

    public $members;

    public function mount()
    {
        $this->members = Organization::find(Context::getOrganizationId())->members()->withPivot('is_active')->get();
    }

    public function render()
    {
        return view('livewire.members');
    }
}
