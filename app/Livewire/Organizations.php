<?php

namespace App\Livewire;

use App\Models\Organization;
use Livewire\Component;

class Organizations extends Component
{

    public $organizations;

    public function toOrganization($id)
    {
        return redirect()->route('organization.dashboard', ['slug' => Organization::find($id)->slug]);
    }


    public function render()
    {
        $this->organizations = auth()->user()->organizations;

        return view('livewire.organizations');
    }
}
