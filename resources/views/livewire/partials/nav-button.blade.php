<div class="relative group {{$collapsed ? 'w-fit' : ''}}">
    <button
        class="{{$collapsed ? 'p-1' : 'px-2 py-1' }} peer flex items-center gap-2 text-left text-sm font-semibold w-full hover:bg-zinc-200 dark:hover:bg-zinc-600  rounded-md transition-colors duration-200"
        wire:navigate
        href="{{$route}}">
                    <span
                        class="flex items-center justify-center w-7 h-7 relative">
                        @if($logo)
                            <img src="{{$logo}}" alt="{{$text}}"/>
                        @else
                            <flux:icon name="{{$icon}}"/>
                        @endif
                    </span>
        <span class="transition-all delay-300 ease-in-out {{$collapsed ? 'opacity-0 hidden' : ''}}">{{$text}}</span>
        @if($badge)
            @if(!$collapsed)
                <flux:spacer/>
                <flux:badge color="zinc" size="sm">{{$badge}}</flux:badge>
            @else
                <div class="absolute top-[6px] right-[4px] w-2 h-2 rounded-full bg-red-400 "></div>
            @endif
        @endif
        @if($beta && !$collapsed)
            <flux:spacer/>
            <flux:badge color="amber" size="sm">Beta</flux:badge>
        @endif

    </button>

    <!-- Tooltip -->
    @if($collapsed)
        <div
            class="absolute z-10 left-[65px] top-1/2 -translate-y-1/2 px-2 py-1 text-xs font-medium rounded-md opacity-0 peer-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap
            dark:text-white dark:bg-zinc-700 bg-white text-zinc-800 border border-zinc-300 dark:border-zinc-600 shadow-sm">
            {{$text}}
        </div>
    @endif
</div>

