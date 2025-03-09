<div class="flex flex-col gap-4">
    <div class="flex flex-col min-h-[100%] w-full">
        <!-- Action bar -->
        <div class="flex justify-between items-center p-4 border-b bg-white sticky top-0 z-10">
            <flux:modal.trigger name="add-track">
                <flux:button icon="plus">Add Track</flux:button>
            </flux:modal.trigger>
            <label for="dateselect" class="hidden">Select a date</label>
            <input type="date" id="dateselect" wire:model="selectedDate" class="border p-2 rounded">
            <flux:button icon="chevron-left" wire:click="changeDate(-1)"/>
            <flux:button icon="chevron-right" wire:click="changeDate(1)"/>
        </div>

        <!-- Conteneur principal scrollable horizontalement -->
        <div class="flex-1 overflow-x-auto relative">
            <div class="relative h-full w-max min-w-full border-t border-gray-300">
                <!-- Grille -->
                <div class="grid grid-cols-24 border-t border-l">
                    @for($i = 0; $i < 24; $i++)
                        <div class="border-r text-center bg-gray-100 p-2">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                        </div>
                    @endfor
                </div>

                <div id="gantt-container" class="grid grid-cols-24 grid-rows-[repeat(12,1fr)] gap-0 gap-y-2 relative">
                    @if ($tracks->isEmpty())
                        <div class="col-start-4 col-span-24 text-center p-4">
                            <flux:heading size="lg">No tracks for this day</flux:heading>
                        </div>
                    @else
                        @foreach($tracks as $track)
                            @php
                                $startHour = $track->started_at->format('H');
                                $endHour = $track->ended_at->format('H');

                                // remove any leading zeros
                                $startHour = ltrim($startHour, '0');
                                $endHour = ltrim($endHour, '0');

                                // convert stings to integers
                                $startHour = (int) $startHour;
                                $endHour = (int) $endHour;

                            @endphp
                            <div class="gantt-task bg-blue-500 text-white p-2 rounded shadow-md"
                                 style="grid-column: {{ $startHour + 1 }} / span {{ $endHour - $startHour }}; grid-row: {{ $loop->index + 1 }};">
                                {{ $track->title }} {{ $track->started_at->format('H:i') }} - {{ $track->ended_at->format('H:i') }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>





    <!-- Modal d'ajout de track -->
    <flux:modal name="add-track" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a Track</flux:heading>
                <flux:subheading>Here you can add a time track!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Task 101" wire:model.defer="title"/>

            <flux:input label="Started At" type="time" wire:model.defer="started_at"/>
            <flux:input label="Ended At" type="time" wire:model.defer="ended_at"/>

            <input type="hidden" wire:model="selectedDate">

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="saveTrack" variant="primary">Add Track</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

