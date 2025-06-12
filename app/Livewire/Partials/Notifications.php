<?php

namespace App\Livewire\Partials;

use App\Enums\NotificationType;
use App\Enums\RoleEnum;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\OrganizationInvites;
use App\Models\User;
use Livewire\Attributes\On;

class Notifications extends HorixtComponent
{
    public $notifications;
    public $unreadCount = 0;
    public $invitesNotifications = [];
    public $unreadNotifications;

    public function markAllAsRead()
    {
        foreach ($this->notifications as $notification) {
            if (!$notification->read_at) {
                $notification->markAsRead();
            }
        }
    }

    #[On('notificationRead')]
    public function getNotifications()
    {
        $this->notifications = auth()->user()->notifications;


        $this->unreadCount = auth()->user()->unreadNotifications->count();
        $this->unreadNotifications = auth()->user()->unreadNotifications;
        $this->invitesNotifications = Notification::where('type', 'like', NotificationType::INVITATION->value)
            ->where('data->email', auth()->user()->email)
            ->where(function ($query) {
                $query->whereNotNull('data->token');

                $query->whereExists(function ($query) {
                    $query->select('id')
                        ->from('organization_invites')
                        ->whereColumn('organization_invites.token', 'app_notifications.data->token')
                        ->where('organization_invites.status', 'pending');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();
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

    public function render()
    {
        self::getNotifications();
        return view('livewire.partials.notifications');
    }
}
