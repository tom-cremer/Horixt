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

        {{--<flux:button
            x-on:click="open = !open"
            :loading="false"
            square size="sm" variant="ghost" class="relative w-8 h-8 flex items-center justify-center">
            @if(($activeTracks->count() > 0))
                <span
                    class="absolute inline-flex h-full w-full max-h-3.5 max-w-3.5 animate-ping rounded-full bg-green-400 opacity-60"></span>
            @endif
            <span
                class="relative w-3 h-3 rounded-full {{!($activeTracks->count() > 0)? 'bg-zinc-500' : 'bg-green-500'}}"></span>
        </flux:button>--}}
        <div
             class="relative w-8 h-8 flex items-center justify-center">
            @if(($activeTracks->count() > 0))
                <span
                    class="absolute inline-flex h-full w-full max-h-3.5 max-w-3.5 animate-ping rounded-full bg-green-400 opacity-60"></span>
            @endif
            <span
                class="relative w-3 h-3 rounded-full {{!($activeTracks->count() > 0)? 'bg-zinc-500' : 'bg-green-500'}}"></span>
        </div>
    </flux:tooltip>
    {{--
    <div x-show="open"
        x-cloak
         x-on:click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute top-full right-0 mt-2 w-64 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-lg p-4 z-50">
        <flux:heading level="3" size="md" class="mb-2">Active Tracks</flux:heading>
        @if($activeTracks->count() > 0)
            <div class="flex flex-col gap-2">
                @foreach($activeTracks as $track)
                    <div class="flex items
                        justify-between p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700">
                        <flux:text variant="strong">{{ $track->todo->name }}</flux:text>
                        <livewire:track :todo="$track->todo->id" :key="'active-todo-track-'.$track->todo->id"/>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-zinc-500 dark:text-zinc-400 text-sm">
                No active tracks
            </div>
        @endif
    </div>--}}
</div>


