<div
     class="flex flex-col gap-2 overflow-y-auto max-h-full">
    @if(!empty($invitesNotifications))
        @foreach($invitesNotifications as $invite)
            <livewire:partials.notifications.invite :inviteId="$invite->id"
                                                    wire:key="invite-{{$invite->id}}-{{ $invite->updated_at }}"/>
        @endforeach
    @else
        <p class="text-zinc-500 dark:text-zinc-400 text-sm">No invites</p>
    @endif
</div>
