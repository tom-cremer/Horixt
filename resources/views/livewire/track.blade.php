<div class="relative flex items-center space-x-2"
     x-data="{
         timer: {{ $this->timer }},
         interval: null,
         startTimer() {
             this.interval = setInterval(() => this.timer++, 1000);
         },
         stopTimer() {
             clearInterval(this.interval);
             this.interval = null;
         }
     }"
     x-init="if ({{ $activeTrack ? 'true' : 'false' }}) startTimer();"
     x-effect="if (!{{ $activeTrack ? 'true' : 'false' }}) stopTimer();"
     @track-ended="stopTimer()">
    @if ($activeTrack)
        <button wire:click="stop" class="">
            <flux:icon name="stop"/>
        </button>
    @else
        <button wire:click="start" class="">
            <flux:icon name="play"/>
        </button>
    @endif

    {{-- Pop-up for Track History --}}

    <flux:button variant="filled" :loading="false" size="sm" wire:click="toggleTrackHistory">
        <span class="text-center min-w-14!" x-text="new Date(timer * 1000).toISOString().substr(11, 8)"></span>
    </flux:button>
    <div wire:click.outside="toggleTrackHistory"
         class="absolute min-w-md min-h-56 top-0 left-1/2 transform  bg-gray-50 dark:bg-zinc-700  shadow-lg rounded-lg p-4 z-[800] {{ $showTrackHistory ? '' : 'hidden' }}">
        <flux:heading size="lg">Track History</flux:heading>
        <flux:text variant="subtle" class="text-xs">Right click on the track to edit</flux:text>
        <div class="flex flex-col gap-1.5 my-4 min-h-44 max-h-44 overflow-auto">
            @foreach($tracks as $track)
                <div
                    class="flex gap-1.5 w-full"
                    wire:key="{{ $track->id }}"
                >
                    <flux:tooltip :content="$track->user->name" placement="top">
                        <flux:avatar :name="$track->user->name" size="xs" initials:single/>
                    </flux:tooltip>

                    @if(isset($this->trackToEdit) && $this->trackToEdit == $track->id)
                        <div class="flex gap-1.5">

                            <flux:input type="time" size="xs" wire:model.live="started_at"
                                        value="{{ $track->started_at->format('H:i:s') }}" step="2" class="w-32!"
                                        x-on:change="$nextTick(() => { $refs.endedAt.min = $event.target.value })"/>
                            <flux:input type="time" size="xs" wire:model.defer="ended_at"
                                        value="{{ $track->ended_at->format('H:i:s') }}" step="2" class="w-32!"
                                        x-ref="endedAt"/>
                            <flux:button :loading="false" :square="true" size="xs" icon="check"
                                         wire:click="update({{ $track->id }})"/>
                            <flux:button :loading="false" :square="true" size="xs" icon="x"
                                         wire:click="cancelEdit"/>
                        </div>
                    @else
                        <div class="flex gap-1.5">

                            <flux:text
                                x-data
                                @contextmenu.prevent="$wire.edit({{ $track->id }})"
                                class="whitespace-nowrap"
                            >
                                {{ $track->started_at->format('H:i:s') }}
                                - {{ $track->ended_at ? $track->ended_at->format('H:i:s') : 'Ongoing' }}
                            </flux:text>
                            @if ($track->ended_at)
                                <flux:text class="whitespace-nowrap">
                                    Duration: {{ $track->durations }} seconds
                                </flux:text>
                            @endif
                        </div>
                    @endif
                    <div class="flex grow gap-1.5 justify-end">
                        @if(!(isset($this->trackToEdit) && $this->trackToEdit == $track->id))

                            <flux:button :loading="false" :square="true" size="xs" icon="square-pen"
                                         wire:click="edit({{ $track->id }})"/>
                        @endif
                        <flux:button :loading="false" :square="true" size="xs" icon="trash-2" variant="danger"
                                     wire:click="deleteTrack({{ $track->id }})"
                        />
                    </div>

                </div>
            @endforeach
        </div>
        <flux:button variant="primary" :loading="false" size="sm" wire:click="toggleTrackHistory">Close</flux:button>
    </div>
    @script
    <script>
        $wire.on('track-ended', () => {
            clearInterval(interval);
            setTimeout(() => $wire.stop(), 1000);
        });
    </script>
    @endscript
</div>

