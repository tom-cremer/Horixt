@php
    $activeTracksMessage = match ($activeTracks->count()) {
        0 => 'No active tracks',
        1 => '1 Track is running',
        default => $activeTracks->count() . ' Tracks are running',
    };
@endphp


<div class="relative"
     x-data="{ open: false }"
>
    <flux:tooltip
        content="{{ $activeTracksMessage }}">

        <flux:button
            x-on:click="open = !open"
            :loading="false"
            square size="sm" variant="ghost" class="relative w-8 h-8 flex items-center justify-center">
            @if(($activeTracks->count() > 0))
                <span
                    class="absolute inline-flex h-full w-full max-h-3.5 max-w-3.5 animate-ping rounded-full bg-green-400 opacity-60"></span>
            @endif
            <span
                class="relative w-3 h-3 rounded-full {{!($activeTracks->count() > 0)? 'bg-zinc-500' : 'bg-green-500'}}"></span>
        </flux:button>
    </flux:tooltip>
    <div x-show="open"
         x-cloak
         x-on:click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute top-full right-0 mt-2 w-72 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-lg p-4 z-50">
        <flux:heading level="3" size="md" class="mb-2">Active Tracks</flux:heading>
        @if($activeTracks->count() > 0)
            <div class="flex flex-col gap-2">
                @foreach($activeTracks as $track)
                    <div class="flex items-center relative
                        justify-between px-2 py-1.5 rounded-lg  bg-zinc-100 dark:bg-zinc-700 group">
                        <flux:text variant="strong" class="truncate max-w-28  ">
                            {{ $track->todo->name }}

                        </flux:text>
                        @if(strlen($track->todo->name) >= 20)
                            <span class="pointer-events-none flex items-center justify-center w-fit whitespace-nowrap break-keep opacity-0 absolute z-50 -top-7 left-0 py-1 px-1.5
                         bg-zinc-100 border border-zinc-300 dark:bg-zinc-700 dark:border-zinc-600
                         rounded-lg group-hover:opacity-100 transition-opacity duration-200
                         text-sm text-zinc-800 dark:text-zinc-200">
                            {{ $track->todo->name }}
                        </span>
                        @endif
                        <livewire:track :todo="$track->todo->id" :modal="false" :key="'track-'.$track->todo->id"/>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-zinc-500 dark:text-zinc-400 text-sm">
                No active tracks
            </div>
        @endif
    </div>
</div>


