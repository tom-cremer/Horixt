<?php

namespace App\Livewire\Partials;

use App\Helper\Context;
use App\Jobs\SendInvites;
use App\Livewire\Component\HorixtComponent;
use App\Models\Organization;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AddMembers extends HorixtComponent
{

    public $email;
    public $inviteEmailList = [];

    public $members = [];

    public function mount()
    {
        $this->members = Context::getOrganization()->members;
        Flux::modal('add-members')->show();

    }

    public function addEmail()
    {
        $this->email = trim($this->email);
        $validated = $this->validate([
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255',
        ]);

        // Check if the email already exists in the members list
        foreach ($this->members as $member) {
            if ($member->email === $validated['email']) {
                $this->reset('email');
                return;
            }
        }

        if (in_array($validated['email'], $this->inviteEmailList)) {
            $this->reset('email');
            return;
        }
        $this->inviteEmailList[] = $validated['email'];
        $this->reset('email');
    }


    public function removeEmail($index)
    {
        unset($this->inviteEmailList[$index]);
        $this->inviteEmailList = array_values($this->inviteEmailList);
    }

    public function sendInvites()
    {
        /*$this->validate([
            'inviteEmailList' => 'required|array|min:1',
            'inviteEmailList.*' => 'email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255',
        ]);*/

        if (empty($this->inviteEmailList)) {
            return;
        }


        SendInvites::dispatch($this->inviteEmailList, auth()->user(), Context::getOrganization());

        $this->reset('inviteEmailList');
        Flux::modal('add-members')->close();
    }


    public function close()
    {
        Flux::modal('add-members')->close();
    }

    public function render()
    {
        return view('livewire.partials.add-members');
    }
}
