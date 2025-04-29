<div class="relative flex items-center space-x-2">
    @if ($activeTrack)
        <button wire:click="stop" class="bg-red-500 text-white px-4 py-2 rounded">
            ⏹ Stop
        </button>
        <span class="text-sm text-gray-500">
            Started at: {{ $activeTrack->started_at->format('H:i:s') }}
        </span>
    @else
        <button wire:click="start" class="">
            ▶️
        </button>
        {{--@foreach($tracks as $track)
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">
                    {{ $track->started_at->format('H:i:s') }} - {{ $track->ended_at ? $track->ended_at->format('H:i:s') : 'Ongoing' }}
                </span>
                @if ($track->ended_at)
                    <span class="text-sm text-gray-500">
                        Duration: {{ $track->durations }} seconds
                    </span>
                @endif
            </div>
        @endforeach--}}
    @endif

    {{-- Pop-up for Track History --}}
    <button wire:click="toggleTrackHistory" class="bg-blue-500 text-white px-4 py-2 rounded">
        Track History
    </button>
    <div class="fixed top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white shadow-lg rounded-lg p-4 z-50 {{ $showTrackHistory ? '' : 'hidden' }}">
        <h3 class="text-lg font-semibold">Track History</h3>
        @foreach($tracks as $track)
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">
                    {{ $track->started_at->format('H:i:s') }} - {{ $track->ended_at ? $track->ended_at->format('H:i:s') : 'Ongoing' }}
                </span>
                @if ($track->ended_at)
                    <span class="text-sm text-gray-500">
                        Duration: {{ $track->durations }} seconds
                    </span>
                @endif
            </div>
        @endforeach
        <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded" wire:click="toggleTrackHistory">
            Close
        </button>
    </div>
</div>
