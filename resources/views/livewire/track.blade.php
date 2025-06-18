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

    @if($modal)
        <flux:button variant="filled" :loading="false" size="sm" wire:click="toggleTrackHistory">
    <span class="text-center min-w-14!" x-text="(() => {
        const seconds = timer;
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
        })()"></span>
        </flux:button>
    @else
        <div
            class="relative flex items-center font-medium justify-center gap-2 whitespace-nowrap bg-zinc-800/5  dark:bg-white/10  h-8 text-sm rounded-md text-center p-2">
            <span class="text-center min-w-14!" x-text="(() => {
        const seconds = timer;
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
        })()"></span>
        </div>
    @endif

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
                    @if($track->user->avatar)
                        <flux:avatar tooltip="{{$track->user->name}}" size="xs" class="ring-0! ring-transparent!"
                                     src="{{\Illuminate\Support\Facades\Storage::url($track->user->avatar->path)}}"/>
                    @else
                        <flux:avatar tooltip="{{$track->user->name}}" size="xs" name="{{$track->user->name}}"
                                     class="ring-0! ring-transparent!" color="auto" color:seed="{{ $track->user->id }}"
                                     initials:single/>
                    @endif

                    @if(isset($this->trackToEdit) && $this->trackToEdit == $track->id)
                        <div class="flex gap-1.5">
                            <flux:input type="datetime-local" size="xs" wire:model.live="started_at"
                                        value="{{ $track->started_at->format('Y-m-d\TH:i:s') }}" step="2" class="w-36!"
                                        x-on:change="$nextTick(() => { $refs.endedAt.min = $event.target.value })"/>
                            <flux:input type="datetime-local" size="xs" wire:model.defer="ended_at"
                                        value="{{ $track->ended_at->format('Y-m-d\TH:i:s') }}" step="2" class="w-36!"
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
                                {{ $track->ended_at ? ($track->started_at->format('d/m/y') === $track->ended_at->format('d/m/y') ? $track->started_at->format('d/m/y H:i') . ' - ' . $track->ended_at->format('H:i') : $track->started_at->format('d/m/y H:i') . ' - ' . $track->ended_at->format('d/m/y H:i')) : 'Ongoing' }}
                            </flux:text>
                            @if ($track->ended_at)
                                <flux:text class="whitespace-nowrap">
                                    Duration: {{ \Carbon\CarbonInterval::seconds($track->durations)->cascade()->locale('en_US')->format('%Hh%Im') }}</flux:text>
                            @endif
                        </div>
                    @endif
                    <div class="flex grow gap-1.5 justify-end">
                        @if(!(isset($this->trackToEdit) && $this->trackToEdit === $track->id))
                            @if( ($track->user_id === auth()->user()->id || auth()->user()->hasRole('admin')) && (\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TRACKS_UPDATE)) )

                                <flux:button :loading="false" :square="true" size="xs" icon="square-pen" variant="filled"
                                             wire:click="edit({{ $track->id }})"/>
                            @endif
                        @endif
                        @if( ($track->user_id === auth()->user()->id || auth()->user()->hasRole('admin')) && (\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TRACKS_DELETE)) )
                            <flux:button :loading="false" :square="true" size="xs" icon="trash-2" variant="filled"
                                         wire:click="deleteTrack({{ $track->id }})"
                            />
                        @endif
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

        if ({{$activeTrack ? 'true' : 'false'}}) {
            window.Echo.private(`track.{{ $activeTrack?->id }}`)
                .listen('TrackStopped', (e) => {
                    if (e.trackId === {{ $activeTrack?->id }}) {
                        $wire.stop();
                    }
                });
        }

    </script>
    @endscript
</div>

