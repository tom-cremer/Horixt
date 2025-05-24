<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use Flux\Flux;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

class Members extends HorixtComponent
{

    private $members = [];
    public $roles;

    public $memberToEdit;
    public $is_active = false;

    public $search = '';
    public $searchResults = [];

    public function mount()
    {
        $this->roles = Role::all();
    }


    public function editMember($id)
    {
        $this->memberToEdit = Context::getOrganization()->allMembers()->find($id);
        $this->is_active = (bool)$this->memberToEdit->pivot->is_active;
        Flux::modal('edit-member')->show();
    }

    public function searchRole()
    {
        $this->searchResults = $this->roles->filter(function ($role) {
            return str_contains($role->name, strtolower($this->search));
        });
    }

    public function removeRole($memberId, $roleId)
    {
        $member = Context::getOrganization()->allMembers()->find($memberId);
        $member->removeRole($roleId);
        $this->dispatch('toast', [
            'title' => 'Role removed',
            'message' => 'Role has been successfully removed',
            'type' => 'success', // success, warning, error, info
        ]);
    }

    public function addRole($memberId, $roleId)
    {
        $member = Context::getOrganization()->allMembers()->find($memberId);
        $member->assignRole($roleId);
        $this->dispatch('toast', [
            'title' => 'Role added',
            'message' => 'Role has been successfully added',
            'type' => 'success', // success, warning, error, info
        ]);
    }


    public function render()
    {
        if ($this->search !== '') {
            $this->searchRole();
        }
        if ($this->search === '') {
            $this->searchResults = [];
        }
        $this->members = Context::getOrganization()->members()->orderBy('joined_at', 'asc')->get();
        return view('livewire.members');
    }
}
