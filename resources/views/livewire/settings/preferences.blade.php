<div class="flex flex-col items-start">

    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Preferences')" :subheading="__('Update your preferences for the application')">
        <div class="flex flex-col gap-6">

            {{--Appearance--}}
            <div class="flex flex-col gap-3 max-w-96">
                <flux:heading level="3">{{ __('Appearance') }}</flux:heading>

                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="hidden sm:flex">
                    <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                    <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                    <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
                </flux:radio.group>

                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="sm:hidden block">
                    <flux:radio value="light" icon="sun"/>
                    <flux:radio value="dark" icon="moon"/>
                    <flux:radio value="system" icon="computer-desktop"/>
                </flux:radio.group>

            </div>

            <flux:separator/>
            {{--Preferred Organization--}}
            <div class="flex flex-col gap-4 ">
                <div>
                    <flux:heading level="3">{{ __('Preferred Organization') }}</flux:heading>
                    <flux:text>
                        Select an organization to be logged in by default (next time you log in)
                    </flux:text>
                </div>

                <flux:dropdown wire:key="pref-org-{{auth()->user()->preferred_organization_id ?? 'personal'}}"
                               class="w-full max-w-96">

                    <flux:button
                        size="sm"
                        class="px-1! w-full text-left justify-between!"
                        icon-trailing="chevron-down"
                    >
                        <div class="truncate flex items-center gap-2">

                            <flux:avatar size="xs" initials="{{ substr($preferredOrganizationName, 0, 1) }}"/>
                            <flux:text>{{ $preferredOrganizationName ?? 'Personal' }}</flux:text>
                        </div>
                    </flux:button>


                    <flux:menu>
                        <flux:menu.group>
                            <flux:menu.item
                                wire:click="updatePreferredOrg(null)"
                            >
                                Personal
                            </flux:menu.item>
                        </flux:menu.group>

                        <flux:menu.group heading="Organizations">
                            @forelse(auth()->user()->organizations as $organization)
                                <flux:menu.item
                                    wire:key="pref-org-{{ $organization->id }}"
                                    wire:click="updatePreferredOrg({{ $organization->id }})"
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


            <flux:separator/>

            {{--Status and Priority Colors--}}
            <div class="flex flex-col gap-4">
            <flux:heading level="3" size="lg">Colors Personalization</flux:heading>
            <div class="grid grid-cols-1 sm:grid-cols-[1fr_auto_1fr] max-w-2xl gap-6">
                {{--Status color--}}
                <div class="flex flex-col gap-3">
                    <flux:heading level="3">Statuses</flux:heading>
                    <div
                        class="flex flex-col gap-2">
                        @foreach($statuses as $status)
                            <div x-data="{ editStatus: false }"
                                 class="relative grid grid-cols-[1fr_auto] gap-2">
                                <flux:badge :color="$status->userStatusColor->color->alias"
                                            class="w-fit">{{ $status->name }} </flux:badge>
                                <div class="relative">

                                    <button x-on:click="editStatus = !editStatus"
                                            class="mr-1.5 p-0.5 w-8 h-6 rounded-md border border-zinc-300 dark:border-zinc-600
                                            focus:outline-none focus:ring-2 focus:ring-zinc-800 dark:focus:ring-zinc-100">
                                <span
                                    class="block {{$status->userStatusColor->color->alias}} w-full h-full rounded-sm"> </span>
                                    </button>
                                    <div x-show="editStatus"
                                         @click.away="editStatus = false"
                                         class="absolute top-full right-0 grid grid-cols-4 items-center justify-center gap-2 bg-zinc-100 dark:bg-zinc-700 p-2 rounded-md z-10 shadow-md min-w-32">
                                        @foreach($colors as $color)
                                            <button wire:click="updateStatusColor({{ $status->id }}, {{ $color->id }})"
                                                    class="w-6 h-6 rounded-full {{ $color->alias }} focus:ring-2 ring-offset-2 ring-zinc-500"
                                                    title="{{ $color->name }}">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <flux:separator vertical class="hidden sm:block"/>
                <flux:separator class="block sm:hidden"/>
                {{--Priority color--}}
                <div class="flex flex-col gap-3">
                    <flux:heading level="3">Priorities</flux:heading>
                    <div
                        class="flex flex-col gap-2">
                        @foreach($priorities as $priority)

                            <div x-data="{ editPriority: false }"
                                 class="relative grid grid-cols-[1fr_auto] gap-2">
                                <flux:badge :color="$priority->userPriorityColor->color->alias"
                                            class="w-fit">{{ $priority->name }} </flux:badge>
                                <div class="relative">

                                    <button x-on:click="editPriority = !editPriority"
                                            class="mr-1.5 p-0.5 w-8 h-6 rounded-md border border-zinc-300 dark:border-zinc-600
                                    focus:outline-none focus:ring-2 focus:ring-zinc-800 dark:focus:ring-zinc-100">
                                    <span
                                        class="block {{$priority->userPriorityColor->color->alias}} w-full h-full rounded-sm"> </span>
                                    </button>
                                    <div x-show="editPriority"
                                         @click.away="editPriority = false"
                                         class="absolute top-full right-0 grid grid-cols-4 items-center justify-center gap-2 bg-zinc-100 dark:bg-zinc-700 p-2 rounded-md z-10 shadow-md min-w-32">
                                        @foreach($colors as $color)
                                            <button
                                                wire:click="updatePriorityColor({{ $priority->id }}, {{ $color->id }})"
                                                class="w-6 h-6 rounded-full {{ $color->alias }} focus:ring-2 ring-offset-2 ring-zinc-500"
                                                title="{{ $color->name }}">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        </div>
    </x-settings.layout>
</div>
