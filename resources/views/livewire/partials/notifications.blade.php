<div
    x-data="{ open: false,allNotifications: true}"
    class="relative"
    x-on:keydown.escape.window="open = false"
    wire:poll.10s>

    <flux:button variant="filled" icon="bell" square size="sm" class="" x-on:click="open = !open"
                 x-on:keydown.alt.n.window="open = !open"/>

    {{--Notification Badge--}}
    @if($unreadCount > 0)
        <span class="absolute top-0 right-0 -mt-1 -mr-1 w-2 h-2 rounded-full bg-[#7F76FF]"></span>
    @endif
    {{--Notifications Tray--}}
    <div
        class="fixed z-50 top-12 right-2.5 sm:right-16 w-full max-w-[300px] sm:max-w-[460px] m-2 max-h-[500px] h-screen overflow-y-auto rounded-lg shadow-lg
        bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 p-2.5
        grid grid-cols-1 grid-rows-[auto_auto_1fr] gap-1.5"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        @click.away="open = false">

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
                <flux:button variant="ghost" size="xs" class="relative font-medium!"
                             x-on:click="allNotifications = true">
                    All Notifications
                    <span x-show="allNotifications"
                          x-cloak
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0 transform scale-95"
                          x-transition:enter-end="opacity-100 transform scale-100"
                          x-transition:leave="transition ease-in duration-100"
                          x-transition:leave-start="opacity-100 transform scale-100"
                          x-transition:leave-end="opacity-0 transform scale-95"

                          class="absolute w-full top-full left-0 mt-1 h-0.5 rounded-full bg-zinc-600 dark:bg-white"></span>
                </flux:button>
                <flux:button variant="ghost" size="xs" class=" relative font-medium!"
                             x-on:click="allNotifications = false">
                    Unread
                    <span x-show="!allNotifications"
                          x-cloak
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0 transform scale-95"
                          x-transition:enter-end="opacity-100 transform scale-100"
                          x-transition:leave="transition ease-in duration-100"
                          x-transition:leave-start="opacity-100 transform scale-100"
                          x-transition:leave-end="opacity-0 transform scale-95"

                          class="absolute w-full top-full left-0 mt-1 h-0.5 rounded-full bg-zinc-600 dark:bg-white"></span>
                </flux:button>
            </div>
        </div>
        <flux:separator/>

        <div
            x-show="allNotifications"
            class="flex flex-col gap-2  overflow-y-auto max-h-full"
        wire:key="all-notifications-{{ $notifications->count() }}">
            @if(empty($notifications))
                <p class="text-zinc-500 dark:text-zinc-400 text-sm">No notifications</p>
            @else
                @if(!empty($invitesNotifications))
                    @foreach($invitesNotifications as $invite)
                        <div class="p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg"
                             wire:key="invite-{{ $invite->id }}">
                            <flux:text variant="strong" class="text-sm">
                                You have been invited to join the team
                                <b>{{ \App\Models\Organization::find($invite->data['organization_id'])->name }}</b>.
                            </flux:text>
                            <div class="flex gap-2 mt-2">
                                <flux:button variant="primary" size="xs"
                                           wire:click="accept({{ $invite->id }})" >
                                    Accept
                                </flux:button>
                                <flux:button variant="filled" size="xs"
                                             wire:click="decline({{ $invite->id }})">Decline
                                </flux:button>
                            </div>
                        </div>

                    @endforeach
                @endif
                @foreach($notifications as $notification)
                    @switch($notification->type)
                        @case(\App\Enums\NotificationType::UNASSIGNMENT)
                            <livewire:partials.notifications.assignment :notificationId="$notification->id"
                                                                        wire:key="unassignment-{{$notification->id}}-{{ $notification->updated_at }}"/>
                            @break
                        @case(\App\Enums\NotificationType::ASSIGNMENT)
                            <livewire:partials.notifications.assignment :notificationId="$notification->id"
                                                                        wire:key="assignment-{{$notification->id}}-{{ $notification->updated_at }}"/>
                            @break
                        @case(\App\Enums\NotificationType::COMMENT)
                            <livewire:partials.notifications.comment :notificationId="$notification->id"
                                                                     wire:key="comment-{{$notification->id}}-{{ $notification->updated_at }}"/>

                            @break
                    @endswitch
                @endforeach
            @endif
        </div>

        <div
            x-show="!allNotifications"
            class="flex flex-col gap-2  overflow-y-auto max-h-full"
        wire:key="unread-notifications-{{ $unreadCount }}">
            @if(empty($unreadNotifications))
                <p class="text-zinc-500 dark:text-zinc-400 text-sm">No notifications</p>
            @else
                @foreach($unreadNotifications as $notification)
                    @switch($notification->type)
                        @case(\App\Enums\NotificationType::UNASSIGNMENT)
                            <livewire:partials.notifications.assignment :notificationId="$notification->id"
                                                                        wire:key="unread-unassignment-{{$notification->id}}-{{ $notification->updated_at }}"/>
                            @break
                        @case(\App\Enums\NotificationType::ASSIGNMENT)
                            <livewire:partials.notifications.assignment :notificationId="$notification->id"
                                                                        wire:key="unread-assignment-{{$notification->id}}-{{ $notification->updated_at }}"/>
                            @break
                        @case(\App\Enums\NotificationType::COMMENT)
                            <livewire:partials.notifications.comment :notificationId="$notification->id"
                                                                     wire:key="unread-comment-{{$notification->id}}-{{ $notification->updated_at }}"/>
                            @break
                    @endswitch
                @endforeach
            @endif
        </div>

    </div>
</div>
