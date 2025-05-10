<div>
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-2">

        @foreach($organizations as $organization)
            <div
                class="min-w-60 w-full min-h-36 p-4 bg-gray-100 rounded-2xl shadow
                hover:bg-gray-200 dark:bg-zinc-600 dark:hover:bg-zinc-700 transition duration-300
                ease-in-out cursor-pointer flex flex-col justify-between gap-2.5"
                wire:click="toOrganization({{ $organization->id }})"
                wire:navigate>
                <div class="grid grid-cols-[auto_1fr] items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        {{substr($organization->name, 0, 1)}}
                    </div>
                    <div class="flex flex-col">
                        <flux:heading size="lg" class="mb-0! font-lexend">{{$organization->name}}</flux:heading>
                        <flux:subheading class="font-lexend">{{$organization->description}}</flux:subheading>
                    </div>
                </div>
                <flux:separator/>
                <div class="grid grid-cols-[1fr_auto_auto] gap-4">
                    <div class="flex flex-col gap-2">
                        <flux:text class="font-lexend font-medium">Team&nbsp;:</flux:text>
                        <div class="flex"> {{--Team bubbles--}}
                            <livewire:partials.team-bubble mode="members" :organization="$organization"
                                                           :key="$organization->id"/>
                        </div>
                    </div>
                    <flux:separator vertical/>
                    <div class="flex flex-col gap-2 justify-center">
                        <flux:text class="font-lexend font-medium">Owner&nbsp;:</flux:text>
                        <livewire:partials.team-bubble mode="owner" :organization="$organization"
                                                       :key="$organization->id"/>

                    </div>
                </div>

            </div>
        @endforeach


    </div>
</div>
