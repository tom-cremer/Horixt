<div>
    <flux:modal.trigger name="add-members">
        <flux:button size="sm">Add Members</flux:button>
    </flux:modal.trigger>

    <flux:modal name="add-members" class="min-w-96 w-full max-w-xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add members</flux:heading>
                <flux:text class="mt-2">Invites members to the organization.</flux:text>
            </div>

            <flux:input
                label="Members"
                placeholder="Enter email addresses separated by spaces"
                wire:model.defer="email"
                type="email"
                class="w-full"
                wire:keydown.space.prevent="addEmail"
            />
            <div class="flex flex-col gap-2.5 mb-4">
                <flux:heading size="lg">Invitees</flux:heading>
                <div class="flex flex-wrap gap-2">

                    @forelse($inviteEmailList as $key => $invitees)
                        <flux:badge variant="pill" color="cyan" size="sm">
                            {{$invitees}}
                            <flux:badge.close wire:click="removeEmail({{$key}})"/>
                        </flux:badge>
                    @empty
                        <flux:text>No emails added</flux:text>
                    @endforelse
                </div>

            </div>

            <div class="flex gap-4">
                <flux:spacer/>
                <flux:button wire:click="close">Cancel</flux:button>
                <flux:button type="submit" variant="primary" wire:click="sendInvites">Send Invites</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
