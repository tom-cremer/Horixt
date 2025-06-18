<div
     class="flex flex-col gap-2 overflow-y-auto max-h-full">
    @if(empty($unreadNotifications))
        <p class="text-zinc-500 dark:text-zinc-400 text-sm">No Unread Notifications</p>
    @else
        @foreach($unreadNotifications as $notification)
            @if($notification->type === \App\Enums\NotificationType::UNASSIGNMENT)
                <livewire:partials.notifications.assignment :notificationId="$notification->id"
                                                            wire:key="unassignment-{{$notification->id}}-{{$notification->updated_at}}"/>
            @elseif($notification->type === \App\Enums\NotificationType::ASSIGNMENT)
                <livewire:partials.notifications.assignment :notificationId="$notification->id"
                                                            wire:key="assignment-{{$notification->id}}-{{$notification->updated_at}}"/>

            @else
                <livewire:partials.notifications.comment :notificationId="$notification->id"
                                                         wire:key="comment-{{$notification->id}}-{{$notification->updated_at}}"/>

            @endif
        @endforeach
    @endif
</div>
