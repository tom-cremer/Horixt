<aside
       class=" {{ $collapsed ? 'w-16 px-2 py-5' : 'w-72 p-5' }} flex flex-col border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 row-span-2 max-h-screen transition-all duration-300">

    <button wire:click="toggle()" class="p-2 mb-4 bg-zinc-200 rounded hover:bg-zinc-300">☰</button>

    <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2 " wire:navigate>
        <x-app-logo/>
    </a>

    <div class="flex flex-col gap-1 mt-4">
        <div class="relative group {{$collapsed ? 'w-fit' : ''}}">
            <button
                class="peer flex items-center gap-2 p-2 text-left text-sm font-semibold w-full hover:bg-zinc-200 rounded-xl transition-colors duration-200"
                wire:navigate
                href="{{ route('dashboard') }}">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 relative">
                        <flux:icon name="house"/>
                    </span>
                <span class="transition-all delay-300 ease-in-out {{$collapsed ? 'opacity-0 hidden' : ''}}">Dashboard</span>
            </button>

            <!-- Tooltip -->
            @if($collapsed)
                <div
                    class="absolute z-10 left-[65px] top-1/2 -translate-y-1/2 px-2 py-1 text-xs text-white bg-neutral-800 rounded-md opacity-0 peer-hover:opacity-100 transition-opacity">
                    Dashboard
                </div>
            @endif
        </div>
        <div class="relative group {{$collapsed ? 'w-fit' : ''}}">
            <button
                class="peer flex items-center gap-2 p-2 text-left text-sm font-semibold w-full hover:bg-zinc-200 rounded-xl transition-colors duration-200"
                wire:navigate
                href="{{ route('tracks') }}">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 relative">
                        <x-icons.gantt-chart/>
                    </span>
                <span class="transition-all delay-300 ease-in-out {{$collapsed ? 'opacity-0 hidden' : ''}}">Tracks</span>
            </button>

            <!-- Tooltip -->
            @if($collapsed)
                <div
                    class="absolute z-10 left-[65px] top-1/2 -translate-y-1/2 px-2 py-1 text-xs text-white bg-neutral-800 rounded-md opacity-0 peer-hover:opacity-100 transition-opacity">
                    Tracks
                </div>
            @endif
        </div>
        <div class="relative group {{$collapsed ? 'w-fit' : ''}}">
            <button
                class="peer flex items-center gap-2 p-2 text-left text-sm font-semibold w-full hover:bg-zinc-200 rounded-xl transition-colors duration-200"
                wire:navigate
                href="{{ route('projects.index') }}">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 relative">
                        <flux:icon name="layout-grid"/>
                    </span>
                <span class="transition-all delay-300 ease-in-out {{$collapsed ? 'opacity-0 hidden' : ''}}">Projects</span>
            </button>

            <!-- Tooltip -->
            @if($collapsed)
                <div
                    class="absolute z-10 left-[65px] top-1/2 -translate-y-1/2 px-2 py-1 text-xs text-white bg-neutral-800 rounded-md opacity-0 peer-hover:opacity-100 transition-opacity">
                    Projects
                </div>
            @endif
        </div>
    </div>

    {{--Spacer--}}
    <div class="flex-grow"></div>

    <!-- Desktop User Menu -->
    <flux:dropdown position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
        />

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
                <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
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
