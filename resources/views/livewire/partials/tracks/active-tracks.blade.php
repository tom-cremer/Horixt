@php
    $activeTracksMessage = match ($activeTracks->count()) {
        0 => 'No active tracks',
        1 => '1 Track\'s running',
        default => $activeTracks->count() . ' Tracks are running',
    };
@endphp


<div class="relative">
    <flux:tooltip
        content="{{ $activeTracksMessage }}"
    >

        <span class="relative flex size-3">
            @if(($activeTracks->count() > 0))
                <span
                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
            @endif
          <span
              class="relative inline-flex size-3 rounded-full {{!($activeTracks->count() > 0)? 'bg-zinc-500' : 'bg-green-500'}}"></span>
        </span>
    </flux:tooltip>
</div>


