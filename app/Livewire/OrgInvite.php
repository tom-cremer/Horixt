<?php

namespace App\Livewire;

use App\Enums\RoleEnum;
use App\Livewire\Component\HorixtComponent;
use App\Models\OrganizationInvites;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrgInvite extends HorixtComponent
{

    public $token;

    #[Computed]
    public $invite;
    public $organization;
    public $invited_by;
    public $invited_user;


    public function mount($token)
    {
        $this->token = $token;
        $this->invite = OrganizationInvites::where('token', $this->token)->first();
        $this->organization = $this->invite->organization;
        $this->invited_by = $this->invite->user;
        $this->invited_user = User::where('email', $this->invite->email)->first();

    }

    public function accept()
    {
        // Logic to accept the invite
        if ($this->invited_user) {
            $this->invite->status = 'accepted';
            $this->invite->save();

            $this->invited_user->organizations()->attach($this->organization->id, [
                'joined_at' => now(),
            ]);
            // Set Member Role to Invited_user
            session(['team_id' => $this->organization->id]);
            setPermissionsTeamId(session('team_id'));
            $this->invited_user->assignRole(RoleEnum::MEMBER->value);
        }
    }

    public function createAccount()
    {
        return redirect()->route('register', ['email' => $this->invite->email]);
    }

    public function render()
    {
        return view('livewire.org-invite')->layout('components.layouts.invite-layout');
    }
}
