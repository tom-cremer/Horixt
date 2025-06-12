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

    <livewire:partials.organization-select :collapsed="$collapsed" wire:key="organization-select"/>

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
            <livewire:partials.nav-button :collapsed="$collapsed" icon="target" text="Assigned To Me"
                                          route="{{route('organization.assigned-to-me', \App\Helper\Context::getOrganizationSlug())}}"/>
        @endif
        {{--<livewire:partials.nav-button :collapsed="$collapsed" icon="envelope" text="Inbox"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.projects.index') : route('organization.projects.index', \App\Helper\Context::getOrganizationSlug()) }}"/>
        --}}
        <livewire:partials.nav-button :collapsed="$collapsed" icon="folder" text="Files" beta="true"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.files') : route('organization.files', \App\Helper\Context::getOrganizationSlug()) }}"/>
        <livewire:partials.nav-button :collapsed="$collapsed" icon="notebook" text="Notes"
                                      route="{{ \App\Helper\Context::isPersonal() ? route('personal.notes') : route('organization.notes', \App\Helper\Context::getOrganizationSlug()) }}"/>
        <flux:separator/>

        {{-- Trays --}}

        {{--Favorite Tray--}}

        <div class="relative group {{$collapsed ? 'w-fit' : ''}}">
            <div
                class=" peer {{$collapsed ? 'flex' : 'grid grid-cols-[1fr_auto]'}} items-center gap-2 text-left text-sm font-semibold w-full "
            >

                <button
                    class="{{$collapsed ? 'p-1' : 'px-2 py-1' }} flex items-center gap-2  transition-colors duration-200 cursor-pointer"
                    href="{{ \App\Helper\Context::isPersonal() ? route('personal.projects.index') : route('organization.projects.index', \App\Helper\Context::getOrganizationSlug()) }}"
                    wire:navigate>
                <span
                    class="flex items-center justify-center w-7 h-7 relative">
                            <flux:icon name="star"/>
                    </span>
                    <span class="transition-all delay-300 ease-in-out {{$collapsed ? 'opacity-0 hidden' : ''}}">
                        Favorites
                    </span>
                </button>
                @unless($collapsed)
                    <flux:button square :icon="$favTray ? 'chevron-down': 'chevron-right'" variant="subtle"
                                 size="xs"
                                 class="ml-auto" :loading="false"
                                 wire:click.stop="toggleFavTray"
                                 wire:keydown.alt.f.window.prevent="toggleFavTray"
                    />
                @endunless
            </div>
            <!-- Tooltip -->
            @if($collapsed)
                <div
                    class="absolute z-10 left-[65px] top-1/2 -translate-y-1/2 px-2 py-1 text-xs font-medium rounded-md opacity-0 peer-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap
                        dark:text-white dark:bg-zinc-700 bg-white text-zinc-800 border border-zinc-300 dark:border-zinc-600 shadow-sm">
                    Favorites
                </div>
            @endif
        </div>
        <div x-data="{FavTray: $wire.entangle('favTray')}" x-show="FavTray"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="{{ $collapsed ? 'm-auto' : 'ml-4' }} transition-all duration-150 flex flex-col gap-1">
            @foreach($this->favProjects as $favorite)
                <livewire:partials.nav-button :collapsed="$collapsed" icon="panels-top-left"
                                              :text="$favorite->project->name"
                                              wire:key="fav-{{ $favorite->project->id }}-{{ $favorite->project->updated_at }}"
                                              route="{{ \App\Helper\Context::isPersonal()
                             ? route('personal.projects.show', ['projectid' => $favorite->project->id])
                             : route('organization.projects.show', ['slug' => \App\Helper\Context::getOrganizationSlug(), 'projectid' => $favorite->project->id]) }}"/>
            @endforeach
        </div>
        <flux:separator/>
        {{--Project Tray--}}
        <div class="relative group {{$collapsed ? 'w-fit' : ''}}">
            <div
                class=" peer {{$collapsed ? 'flex' : 'grid grid-cols-[1fr_auto]'}} items-center gap-2 text-left text-sm font-semibold w-full "
            >

                <button
                    class="{{$collapsed ? 'p-1' : 'px-2 py-1' }} w-full flex items-center gap-2 hover:bg-zinc-200 dark:hover:bg-zinc-600  rounded-md transition-colors duration-200 cursor-pointer"
                    href="{{ \App\Helper\Context::isPersonal() ? route('personal.projects.index') : route('organization.projects.index', \App\Helper\Context::getOrganizationSlug()) }}"
                    wire:navigate>
                <span
                    class="flex items-center justify-center w-7 h-7 relative">
                            <flux:icon name="layout-grid"/>
                    </span>
                    <span class="transition-all delay-300 ease-in-out {{$collapsed ? 'opacity-0 hidden' : ''}}">
                        Projects
                    </span>
                </button>
                @unless($collapsed)
                    <flux:button square :icon="$projectTray ? 'chevron-down': 'chevron-right'" variant="subtle"
                                 size="xs"
                                 class="ml-auto" :loading="false"
                                 wire:click.stop="toggleTray"
                                 wire:keydown.alt.g.window.prevent="toggleTray"
                    />
                @endunless
            </div>
            <!-- Tooltip -->
            @if($collapsed)
                <div
                    class="absolute z-10 left-[65px] top-1/2 -translate-y-1/2 px-2 py-1 text-xs font-medium rounded-md opacity-0 peer-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap
            dark:text-white dark:bg-zinc-700 bg-white text-zinc-800 border border-zinc-300 dark:border-zinc-600 shadow-sm">
                    Projects
                </div>
            @endif
        </div>
        <div x-data="{projectTray: $wire.entangle('projectTray')}" x-show="projectTray"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="{{ $collapsed ? 'm-auto' : 'ml-4' }} transition-all duration-150 flex flex-col gap-1">
            @foreach($this->projects as $project)
                <livewire:partials.nav-button :collapsed="$collapsed" icon="panels-top-left"
                                              :text="$project->name"
                                              wire:key="project-{{ $project->id }}-{{ $project->updated_at->timestamp }}"
                                              route="{{ \App\Helper\Context::isPersonal()
                             ? route('personal.projects.show', ['projectid' => $project->id])
                             : route('organization.projects.show', ['slug' => \App\Helper\Context::getOrganizationSlug(), 'projectid' => $project->id]) }}"/>
            @endforeach
        </div>


    </div>


    {{--Spacer--}}
    <div class="flex-grow"></div>

    {{-- Avatar Menu --}}
    <flux:dropdown position="bottom" align="start" class="{{ $collapsed ? 'ml-auto mr-auto w-fit' : '' }}">

        @if($collapsed)

            @if(auth()->user()->avatar)

                <flux:profile
                    :chevron="false"
                    :initials="auth()->user()->initials()"
                    avatar="{{\Illuminate\Support\Facades\Storage::url(\auth()->user()->avatar->path)}}"
                />
            @else
                <flux:profile
                    :chevron="false"
                    :initials="auth()->user()->initials()"
                />
            @endif
        @else
            @if(auth()->user()->avatar)

                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    avatar="{{\Illuminate\Support\Facades\Storage::url(\auth()->user()->avatar->path)}}"
                />
            @else
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                />
            @endif
        @endif

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                        @if(auth()->user()->avatar)
                            <flux:avatar tooltip="{{auth()->user()->name}}" size="sm"
                                         class="ring-0! ring-transparent!"
                                         src="{{\Illuminate\Support\Facades\Storage::url(auth()->user()->avatar->path)}}"/>
                        @else
                            <flux:avatar tooltip="{{auth()->user()->name}}" size="sm"
                                         name="{{auth()->user()->name}}"
                                         class="ring-0! ring-transparent!²"
                                         color="auto"
                                         color:seed="{{ auth()->user()->id }}"
                                         initials:single/>
                        @endif

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item
                    href="{{(\App\Helper\Context::isOrganization())? route('organization.settings', ['slug' => \App\Helper\Context::getOrganizationSlug()]) : route('personal.settings')}}"
                    icon="cog"
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
