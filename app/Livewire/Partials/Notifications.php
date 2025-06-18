<?php

namespace App\Livewire\Partials;

use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use Livewire\Attributes\On;

class Notifications extends HorixtComponent
{

    public $open = false;

    public $notifications;
    public $unreadCount = 0;
    public $invitesNotifications = [];
    public $unreadNotifications;

    public $tabs = [
        'all' => [
            'label' => 'All',
        ],
        'unread' => [
            'label' => 'Unread',
        ],
        'invites' => [
            'label' => 'Invites',
        ],
    ];

    public function mount(): void
    {
        $this->open = false;
    }

    public $activeTab = 'all';

    public function changeTab(string $key)
    {
        $this->activeTab = $key;
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }


    public function markAllAsRead()
    {
        TimezoneHelper::set();
        auth()->user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->dispatch('mark-all-as-read');
    }

    public function closeNotificationPanel()
    {
        $this->open = false;
    }

    #[On('mark-all-as-read')]
    public function render()
    {
        $this->unreadCount = auth()->user()->notifications()
            ->whereNotNull('user_id')
            ->whereNull('read_at')
            ->count();

        return view('livewire.partials.notifications');
    }
}
