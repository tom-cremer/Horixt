<?php

namespace App\Livewire\Partials\Notifications;

use Livewire\Attributes\On;
use Livewire\Component;

#[On('mark-all-as-read')]
class NotificationListUnread extends Component
{

    public $unreadNotifications;

    public function mount()
    {
        $this->unreadNotifications = auth()->user()->notifications()
            ->whereNull('read_at')
            ->where('type', '!=', 'invitation')
            ->latest()
            ->get();
    }

    public function render()
    {
        $this->unreadNotifications = auth()->user()->notifications()
            ->whereNull('read_at')
            ->where('type', '!=', 'invitation')
            ->latest()
            ->get();
        return view('livewire.partials.notifications.notification-list-unread');
    }
}
