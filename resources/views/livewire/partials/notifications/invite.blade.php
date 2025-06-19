<div class="p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg"
     wire:key="invite-{{ $invite->id }}">
    <flux:text variant="strong" class="text-sm">
        You have been invited to join the team
        <b>{{ \App\Models\Organization::find($invite->data['organization_id'])->name }}</b>.
    </flux:text>

@if($orgInvite->status === 'pending' )

    <div class="flex gap-2 mt-2">
        <flux:button variant="primary" size="xs"
                     wire:click="accept({{ $invite->id }})">
            Accept
        </flux:button>
        <flux:button variant="filled" size="xs"
                     wire:click="decline({{ $invite->id }})">Decline
        </flux:button>
    </div>
@elseif($orgInvite->status === 'accepted')
    <div class="flex gap-2 mt-2">
        <flux:button variant="filled" size="xs" wire:click="goToOrg">
            Go to Organization
        </flux:button>
    </div>
@else
    <div class="flex gap-2 mt-2">
        <flux:text variant="subtle" class="text-sm">
            Your invitation has been {{ $orgInvite->status }}.
        </flux:text>
    </div>
@endif

</div>
