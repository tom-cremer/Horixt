<?php

namespace App\Livewire\Partials;

use App\Livewire\Component\HorixtComponent;
use App\Models\Organization;
use Livewire\Component;

class TeamBubble extends HorixtComponent
{

    public Organization $organization;

    public $mode;
    public $members;
    public $owner;

    public function mount(): void
    {
        $this->owner = $this->organization->owner;
        $this->members = $this->organization->activeMembers()->get();
        // remove the owner from the members list
        $this->members = $this->members->reject(function ($member) {
            return $member->id === $this->owner->id;
        });
    }

    public function render()
    {
        return view('livewire.partials.team-bubble');
    }
}
