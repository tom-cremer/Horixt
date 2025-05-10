<div
    class="flex flex-col min-w-96 w-full max-w-lg m-auto shadow-lg rounded-2xl bg-white dark:bg-zinc-700 p-6 font-lexend!">
    <div class="flex items-center justify-center gap-3">
        <x-app-logo-icon size="medium"/>
        <flux:heading size="xl" level="1" class="font-bold! font-lexend">{{ config('app.name') }}</flux:heading>
    </div>

    <div class="flex flex-col items-center justify-center mt-6 text-center">
        <flux:text class="text-xl! text-accent">
            You've been invited to join <b>{{ $organization->name }}</b>
        </flux:text>

        @if ($invited_by ?? false)
            <flux:text size="md" class="text-muted mt-6">
                Invited by <b>{{ $invited_by->name }}</b>
            </flux:text>
        @endif

        <flux:text size="sm" class="text-muted mt-6 max-w-md">
            By joining this organization, you’ll be able to collaborate on projects, manage tasks, and access team
            features. Click below to accept the invitation.
        </flux:text>

        @if (empty($invited_user))
            <flux:text size="sm" class="text-muted mt-6 max-w-md">
                You don't have an account yet, you can create one by clicking the button below.
            </flux:text>
            <flux:button variant="primary" class="mt-6" wire:click="createAccount">
                Create Account
            </flux:button>
        @elseif ($invite->status === 'pending')
            <flux:button variant="primary" class="mt-6" wire:click="accept">
                Accept Invitation
            </flux:button>
        @elseif ($invite->status === 'expired')
            <flux:text size="sm" class="text-red-300 mt-6 max-w-md">
                This invitation has expired.
            </flux:text>
        @else
            <flux:text size="lg" class="text-emerald-300 mt-6 max-w-md">
                This invitation has been accepted.
            </flux:text>
        @endif

        <flux:text size="sm" class="text-neutral-400/80! mt-6 max-w-md">
            If you're not concerned by this invite, you can safely ignore it.
        </flux:text>

    </div>
</div>
