<div class="relative">
    <flux:tooltip content="{{!($activeTracks->count() > 0) ? 'No active tracks': 'Active Tracks'}}">
        <flux:button :loading="false" square size="sm" variant="ghost" wire:click="toggle">
        <span class="relative flex size-3">
            @if(($activeTracks->count() > 0))
                <span
                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
            @endif
          <span
              class="relative inline-flex size-3 rounded-full {{!($activeTracks->count() > 0)? 'bg-zinc-500' : 'bg-green-500'}}"></span>
        </span>
        </flux:button>
    </flux:tooltip>

    @if($expanded || $activeTracks->count() > 0)
        <div
            class="absolute bg-neutral-50 border border-zinc-200 dark:border-zinc-500 dark:bg-zinc-700 top-100 right-0 rounded shadow-md p-4">
            @if($activeTracks->count() > 0)
                <ul>
                    @foreach($activeTracks as $track)
                        <flux:text>{{ $track->todo->name }}</flux:text>
                        <livewire:track :todo="$track->todo->id" :key="'active-track-'.$track->id"/>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 dark:text-gray-400">No active tracks available.</p>
            @endif
        </div>
    @endif
</div>


