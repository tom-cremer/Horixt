<div class="flex gap-4">
    <div class="flex flex-col min-h-[100%] w-full">
        <!-- Action bar -->
        <div class="flex justify-between items-center p-4 border-b sticky top-0 z-10">
            <flux:modal.trigger name="add-track" class="flex items-center gap-2">
                <flux:button icon="plus">Add Track</flux:button>
            </flux:modal.trigger>

            <label for="dateselect" class="hidden">Select a date</label>
            <input type="date" id="dateselect" wire:model="selectedDate" class="border p-2 rounded">
            <flux:button icon="chevron-left" wire:click="changeDate(-1)"/>
            <flux:button icon="chevron-right" wire:click="changeDate(1)"/>
        </div>

        <!-- Conteneur principal scrollable horizontalement -->
        <div class="flex-1 overflow-x-auto relative">
            <div class="relative h-full w-max min-w-full  border-gray-300">
                <!-- Grille (Header for Hours) -->
                <div class="grid grid-cols-24 border-t border-l">
                    @for($i = 0; $i < 24; $i++)
                        <div class="border-r text-center bg-gray-100 dark:bg-zinc-800 p-2 w-[100px]">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                        </div>
                    @endfor
                </div>

                <!-- Gantt Container (Now uses absolute positioning) -->
                <div id="gantt-container" class="relative h-[80vh] border-t border-gray-300 py-2">
                    @if ($tracks->isEmpty())
                        <div class="absolute left-1/4 top-1/2 transform -translate-y-1/2 text-center">
                            <flux:heading size="lg">No tracks for this day</flux:heading>
                        </div>
                    @else
                        @foreach($tracks as $track)
                            @php
                                $startHour = $track->started_at->format('H');
                                $endHour = $track->ended_at->format('H');
                                $startMinute = $track->started_at->format('i');
                                $endMinute = $track->ended_at->format('i');

                                // remove any leading zeros
                                $startHour = ltrim($startHour, '0');
                                $endHour = ltrim($endHour, '0');
                                $startMinute = ltrim($startMinute, '0');
                                $endMinute = ltrim($endMinute, '0');

                                // convert stings to integers
                                $startHour = (int) $startHour;
                                $endHour = (int) $endHour;
                                $startMinute = (int) $startMinute;
                                $endMinute = (int) $endMinute;

                                // Convert time to percentage for positioning
                                $left = ($startHour * 100) + ($startMinute / 60 * 100); // 100px per hour
                                $width = (($endHour * 60 + $endMinute) - ($startHour * 60 + $startMinute)) / 60 * 100;
                                $top = $loop->index * 50; // Stacking tasks to avoid overlap
                            @endphp
                            <flux:dropdown position="bottom" align="start"
                                           class="gantt-task absolute"
                                           style="left: {{ $left }}px; width: {{ $width }}px; top: {{ $top+4 }}px;">
                                <button class="flex w-full justify-start rounded-md p-2 {{$track->color->alias}} {{$track->color->alias}}--text">
                                    {{ $track->title  }}
                                </button>
                                <flux:menu class="w-[180px] {{$track->color->light_color}} dark:{{$track->color->dark_color}}">
                                    <flux:menu.item wire:click="editTrack({{ $track->id }})">
                                        Edit
                                    </flux:menu.item>
                                    <flux:menu.item wire:click="deleteTrack({{ $track->id }})">
                                        Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Modal d'edit de track --}}
    <flux:modal name="edit-track" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Track</flux:heading>
                <flux:subheading>Here you can edit a time track!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Task 101" wire:model.defer="title"/>

            <flux:input label="Started At" type="time" wire:model.defer="started_at"/>
            <flux:input label="Ended At" type="time" wire:model.defer="ended_at"/>

            <flux:select label="Colors" wire:model="color_id" placeholder="Select a color">
                @foreach($colors as $color)
                    <flux:select.option value="{{ $color->id }}" label="{{ $color->name }}"/>
                @endforeach
            </flux:select>

            <input type="hidden" wire:model="trackId">

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="updateTrack({{$trackId}})" variant="primary">Update Track
                </flux:button>
            </div>
        </div>
    </flux:modal>
    <!-- Modal d'ajout de track -->
    <flux:modal name="add-track" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a Track</flux:heading>
                <flux:subheading>Here you can add a time track!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Task 101" wire:model.defer="title"/>

            <flux:input label="Started At" type="time" wire:model.defer="started_at"/>
            <flux:input label="Ended At" type="time" wire:model.defer="ended_at"/>

            <flux:select label="Colors" wire:model="color_id" placeholder="Select a color">
                @foreach($colors as $color)
                    <flux:select.option value="{{ $color->id }}" label="{{ $color->name }}"/>
                @endforeach
            </flux:select>


            <input type="hidden" wire:model="selectedDate">

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="createTrack" variant="primary">Add Track</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

