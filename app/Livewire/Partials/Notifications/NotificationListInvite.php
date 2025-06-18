<?php

namespace App\Livewire\Partials\Notifications;

use App\Enums\NotificationType;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('mark-all-as-read')]
class NotificationListInvite extends Component
{
    public $invitesNotifications;

    public function mount(): void
    {
        $this->invitesNotifications = auth()->user()->notifications()
            ->where('type', NotificationType::INVITATION)
            ->where(function ($query) {
                $query->whereNotNull('data->token')
                    ->whereExists(function ($query) {
                        $query->select('id')
                            ->from('organization_invites')
                            ->whereColumn('organization_invites.token', 'app_notifications.data->token');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        $this->invitesNotifications = auth()->user()->notifications()
            ->where('type', NotificationType::INVITATION)
            ->where(function ($query) {
                $query->whereNotNull('data->token')
                    ->whereExists(function ($query) {
                        $query->select('id')
                            ->from('organization_invites')
                            ->whereColumn('organization_invites.token', 'app_notifications.data->token');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.partials.notifications.notification-list-invite');
    }
}
