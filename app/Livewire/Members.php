<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;

class Members extends HorixtComponent
{

    private $members = [];
    public $memberToEdit;

    #[On('edit-member-done')]
    public function loadMembers()
    {
        $this->members = Context::getOrganization()->members;
    }

    public function editMember($id)
    {
        $this->memberToEdit = User::find($id);
        Flux::modal('edit-member')->show();
    }

    public function render()
    {

        $this->members = Context::getOrganization()->members;
        return view('livewire.members');
    }
}
