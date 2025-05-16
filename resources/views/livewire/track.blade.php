<div class="relative flex items-center space-x-2"
     x-data="{
         timer: {{ $timer }},
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

    <flux:button variant="filled" :loading="false" size="sm"  wire:click="toggleTrackHistory">
        <span class="text-center min-w-14!" x-text="new Date(timer * 1000).toISOString().substr(11, 8)"></span>
    </flux:button>
    <div wire:click.outside="toggleTrackHistory"
         class="fixed top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-50 dark:bg-zinc-700  shadow-lg rounded-lg p-4 z-50 {{ $showTrackHistory ? '' : 'hidden' }}">
        <h3 class="text-lg font-semibold">Track History</h3>
        <div class="my-4">

            @foreach($tracks as $track)
                <div class="flex items-center space-x-2">
                    <flux:text>
                        {{ $track->started_at->format('H:i:s') }}
                        - {{ $track->ended_at ? $track->ended_at->format('H:i:s') : 'Ongoing' }}
                    </flux:text>

                    @if ($track->ended_at)
                        <flux:text>
                            Duration: {{ $track->durations }} seconds
                        </flux:text>
                    @endif
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

