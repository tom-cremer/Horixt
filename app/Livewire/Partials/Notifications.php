<?php

namespace App\Livewire\Partials;

use App\Enums\NotificationType;
use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
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

    public function render()
    {
        self::getNotifications();
        return view('livewire.partials.notifications');
    }
}
