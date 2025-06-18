<?php

namespace App\Livewire\Partials\Notifications;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('mark-all-as-read')]
class NotificationList extends Component
{
    public $notifications;


    public function render()
    {
        $this->notifications = auth()->user()->notifications()
            ->whereNotNull('user_id')
            ->where('type', '!=', 'invitation')
            ->latest()
            ->get();
        return view('livewire.partials.notifications.notification-list');
    }
}
