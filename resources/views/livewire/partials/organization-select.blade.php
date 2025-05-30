<div class="font-lexend mb-2 {{($collapsed)? 'flex items-center justify-center': ''}}">
    <flux:dropdown>
        <flux:button
            size="sm"
            class="px-1! {{ (!$collapsed) ? 'w-full text-left justify-between!' : 'w-fit m-auto' }}"
            icon-trailing="{{(!$collapsed)? 'chevron-down': ''}}"
            :square="$collapsed"
        >
            <div class="truncate flex items-center gap-2">

                <flux:avatar size="xs" initials="{{ substr($selectedOrganization->name, 0, 1) }}" />
                @if(!$collapsed)
                    <flux:text>{{ $selectedOrganization->name ?? 'Personal' }}</flux:text>
                @endif
            </div>
        </flux:button>


        <flux:menu>
            <flux:menu.group>
                <flux:menu.item
                    href="{{ route('personal.dashboard') }}"
                    wire:navigate
                >
                    Personal
                </flux:menu.item>
            </flux:menu.group>

            <flux:menu.group heading="Organizations">
                @forelse($organizations as $organization)
                    <flux:menu.item
                        wire:key="org-{{ $organization->id }}"
                        href="{{ route('organization.dashboard', ['slug' => $organization->slug]) }}"
                        wire:navigate
                        class="truncate!"
                    >
                        {{ $organization->name }}
                    </flux:menu.item>
                @empty
                    <flux:text class="ml-2 mb-1.5">No Organizations</flux:text>
                @endforelse
            </flux:menu.group>
        </flux:menu>
    </flux:dropdown>
</div>
