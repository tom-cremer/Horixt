<div
    class="relative"
    wire:keydown.escape.window="closeNotificationPanel"
    wire:click.away="closeNotificationPanel"
    wire:poll.10s.keep-alive
    wire:key="notifications-panel">

    {{--Notification Button--}}

    <flux:button variant="filled" icon="bell" square size="sm" class="" :loading="false" wire:click="toggle"
                 wire:keydown.alt.n.window="toggle"/>

    {{--Notification Badge--}}
    @if($unreadCount > 0)
        <span class="absolute top-0 right-0 -mt-1 -mr-1 w-2 h-2 rounded-full bg-[#7F76FF]"></span>
    @endif
    {{--Notifications Tray--}}

    @if($open)
        <div
            role="dialog"
            aria-label="Notifications panel"
            class="fixed z-50 top-12 right-2.5 sm:right-16 w-full max-w-[300px] sm:max-w-[460px] m-2 max-h-[500px] h-screen overflow-y-auto rounded-lg shadow-lg
        bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 p-2.5
        grid grid-cols-1 grid-rows-[auto_auto_1fr] gap-1.5">

            <div class="grid grid-cols-1 gap-2">
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">
                        Notifications
                    </h3>
                    <flux:button icon="check-check" variant="ghost" size="xs" class="font-medium!"
                                 wire:click="markAllAsRead">
                        Mark all as read
                    </flux:button>
                </div>

                <div class="flex items-center gap-2">
                    @foreach($tabs as $key => $tab)
                        <flux:button :loading="false" variant="ghost" size="xs" class="relative font-medium!"
                                     wire:click="changeTab('{{$key}}')">
                            {{ $tab['label'] }}

                            @if($activeTab === $key)
                                <span
                                    class="absolute w-full top-full left-0 mt-1 h-0.5 rounded-full bg-zinc-600 dark:bg-white"></span>
                            @endif
                        </flux:button>
                    @endforeach

                </div>
            </div>

            <flux:separator/>

            <div class="flex-1 overflow-y-auto max-h-[400px]">
                @if($activeTab === 'unread')
                    <livewire:partials.notifications.notification-list-unread
                    wire:key="unread-notifications"/>
                @elseif($activeTab === 'invites')
                    <livewire:partials.notifications.notification-list-invite
                    wire:key="invites-notifications"/>
                @else
                    <livewire:partials.notifications.notification-list
                    wire:key="all-notifications"/>
                @endif
            </div>
        </div>

    @endif
</div>
