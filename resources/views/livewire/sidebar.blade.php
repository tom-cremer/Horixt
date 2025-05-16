<aside
    class=" relative {{ $collapsed ? 'w-16 px-2 py-4' : 'w-72 p-4' }} transition-all duration-300  flex flex-col border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 row-span-2 max-h-screen transition-all duration-300">

    <button type="button" wire:click="toggle()"
            wire:keydown.ctrl.o.window.prevent="toggle()"
            class="absolute p-1 top-1/2 -right-3 bg-gray-200 dark:bg-zinc-600 rounded-md
        hover:bg-gray-300 dark:hover:bg-zinc-500 transition-all duration-200 ease-in-out">
        <flux:icon name="chevron-right" class="text-zinc-500 dark:text-white
        w-4.5 h-4.5 transition-all duration-200 ease-in-out
        {{ $collapsed ? 'rotate-180' : '' }}"/>
    </button>


    {{-- Logo --}}
    <div class="flex items-center gap-2 p-3 cursor-pointer mr-auto {{ $collapsed ? 'justify-center' : '' }}"
         href="{{ \App\Helper\Context::isPersonal() ? route('personal.dashboard') : route('organization.dashboard', \App\Helper\Context::getOrganizationSlug()) }}"
         wire:navigate>
        {{-- Logo --}}
        <x-app-logo-icon/>
        @if(!$collapsed)
            <h1 class="text-2xl font-bold font-lexend text-center text-zinc-800 dark:text-white">
                {{ config('app.name') }}
            </h1>
        @endif
    </div>

    <livewire:partials.organization-select :collapsed="$collapsed" wire:key="organization-select" />

    <flux:separator/>

    <div class="flex flex-col gap-1 mt-2 {{$collapsed ? 'items-center' : ''}}">
        {{-- Home --}}
        <livewire:partials.nav-button :collapsed="$collapsed" icon="house" text="Dashboard"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.dashboard') : route('organization.dashboard', \App\Helper\Context::getOrganizationSlug()) }}"/>
        @if(\App\Helper\Context::isPersonal())

            <livewire:partials.nav-button :collapsed="$collapsed" icon="building-office-2" text="Organizations"
                                          route="{{route('personal.organizations')}}"/>
        @endif
        @if(\App\Helper\Context::isOrganization())
            <livewire:partials.nav-button :collapsed="$collapsed" icon="users" text="Members"
                                          route="{{route('organization.members', \App\Helper\Context::getOrganizationSlug())}}"/>
        @endif
        <livewire:partials.nav-button :collapsed="$collapsed" icon="envelope" text="Inbox"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.projects.index') : route('organization.projects.index', \App\Helper\Context::getOrganizationSlug()) }}"/>
        <livewire:partials.nav-button :collapsed="$collapsed" icon="folder" text="Files" beta="true"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.files') : route('organization.files', \App\Helper\Context::getOrganizationSlug()) }}"/>
        <flux:separator/>

        <livewire:partials.nav-button :collapsed="$collapsed" icon="layout-grid" text="Projects" beta="true"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.projects.index') : route('organization.projects.index', \App\Helper\Context::getOrganizationSlug()) }}"/>

    </div>

    {{--Spacer--}}
    <div class="flex-grow"></div>
    {{-- Theme Switcher --}}
    @if ($collapsed)
        <flux:dropdown x-data align="end" class="mb-4 {{ $collapsed ? 'ml-auto mr-auto' : '' }}">
            <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini"
                               class="text-zinc-500 dark:text-white"/>
                <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini"
                                class="text-zinc-500 dark:text-white"/>
                <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini"/>
                <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini"/>
            </flux:button>

            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @else
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="mb-4">
            <flux:radio value="light" icon="sun"/>
            <flux:radio value="dark" icon="moon"/>
            <flux:radio value="system" icon="computer-desktop"/>
        </flux:radio.group>
    @endif

    {{-- Avatar Menu --}}
    <flux:dropdown position="bottom" align="start" class="{{ $collapsed ? 'ml-auto mr-auto w-fit' : '' }}">
        @if($collapsed)
            <flux:profile
                :chevron="false"
                :initials="auth()->user()->initials()"
            />
        @else

            <flux:profile
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
            />
        @endif

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <span
                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item href="{{(\App\Helper\Context::isOrganization())? route('organization.settings', ['slug' => \App\Helper\Context::getOrganizationSlug()]) : route('personal.settings')}}" icon="cog"
                                wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>



            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</aside>
