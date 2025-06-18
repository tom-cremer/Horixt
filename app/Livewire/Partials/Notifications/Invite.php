<?php

namespace App\Livewire\Partials\Notifications;

use App\Enums\RoleEnum;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\OrganizationInvites;
use App\Models\User;
use Livewire\Attributes\On;

class Invite extends HorixtComponent
{

    public $inviteId;
    public $invite;
    public $orgInvite;


    public function mount($inviteId): void
    {
        $this->inviteId = $inviteId;
        $this->invite = \App\Models\Notification::find($inviteId);

        if ($this->invite) {
            $this->orgInvite = OrganizationInvites::where('token', $this->invite->data['token'])->first();
        }
    }


    public function accept($inviteId)
    {
        TimezoneHelper::set();

        $invite = Notification::find($inviteId);

        $invitedUser = User::where('email', $invite->data['email'])->first();
        $orgInvite = OrganizationInvites::where('token', $invite->data['token'])
            ->where('status', 'like', 'pending')->first();
        $organization = Organization::find($invite->data['organization_id']);


        // Logic to accept the invite
        if ($invitedUser && $orgInvite && $organization) {
            $orgInvite->status = 'accepted';
            $orgInvite->save();

            $invite->markAsRead();

            $invitedUser->organizations()->attach($organization->id, [
                'joined_at' => now(),
            ]);
            // Set Member Role to Invited_user
            session(['team_id' => $organization->id]);
            setPermissionsTeamId(session('team_id'));
            $invitedUser->assignRole(RoleEnum::MEMBER->value);
            $this->dispatch('toast', [
                'title' => 'Invite accepted',
                'message' => 'You are now part of ' . $organization->name,
                'type' => 'success', // success, warning, error, info
                //'duration' => Default 5000ms,
            ]);
        }
    }

    public function decline($inviteId)
    {
        $invite = Notification::find($inviteId);
        $orgInvite = OrganizationInvites::where('token', $invite->data['token'])
            ->where('status', 'like', 'pending')->first();

        if ($orgInvite) {
            $orgInvite->status = 'declined';
            $orgInvite->save();
            $invite->markAsRead();
        }
    }

    public function goToOrg()
    {

        if ($this->orgInvite) {
            return redirect()->route('organization.dashboard', ['slug' => $this->orgInvite->organization->slug]);
        }
    }

    #[On('mark-all-as-read')]
    public function render()
    {
        return view('livewire.partials.notifications.invite');
    }
}
