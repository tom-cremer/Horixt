<div class="  h-full font-lexend">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
        {{--Weekly summary--}}
        <div class="flex flex-col p-2.5 gap-2.5
        bg-white dark:bg-zinc-700 border border-zinc-200
        dark:border-zinc-600 rounded-lg shadow-sm"
             wire:key="weekly-summary"
        >
            <div class="flex flex-col gap-0.5">
                <flux:heading class="text-lg font-bold">Weekly Summary</flux:heading>
            </div>
            <div class="grid grid-cols-7 gap-2 items-baseline">
                @foreach($this->formatWeeklyCompletedTodo() as $day)
                    <flux:tooltip>
                        <div class="grid grid-cols-1 grid-rows-[1fr_auto] justify-center gap-1 min-h-[120px]">
                            {{--Custom vertical progress bar--}}

                            <div class="relative group flex w-full h-full bg-[#7F76FF]/10 overflow-hidden rounded-2xl"
                                 wire:key="day-{{ $day->date }}">
                                <div
                                    class="mt-auto w-full bg-[#7F76FF] rounded-sm transition-[height] duration-500 ease-in-out"
                                    style="height: {{ $day->percentage }}%"></div>
                            </div>
                            <div class="mx-auto">

                                <flux:text variant="strong" class="text-xs ">{{substr($day->day, 0, 3)}}</flux:text>
                            </div>
                        </div>

                        <flux:tooltip.content class="max-w-[10rem] space-y-2">
                            <p>{{$day->count}} Todos were completed on this day</p>
                        </flux:tooltip.content>
                    </flux:tooltip>

                @endforeach
            </div>
        </div>


        {{--Global overview--}}
        <div class="flex flex-col p-2.5 gap-2.5
        bg-white dark:bg-zinc-700 border border-zinc-200
        dark:border-zinc-600 rounded-lg shadow-sm">
            <div class="flex flex-col gap-0.5">
                <flux:heading class="text-lg font-bold">Global overview</flux:heading>
            </div>

            <div class="flex justify-center items-center h-28 overflow-hidden ">
                <div
                    class="relative h-48 w-48 overflow-hidden translate-y-1/4">

                    <!-- Background circle -->
                    <div class="absolute h-48 w-48 top-0 left-0 border-8 border-[#7F76FF]/15 rounded-full"></div>

                    <!-- Animated progress arc -->
                    <div class="absolute h-48 w-48 top-0 left-0 border-8 border-b-[#7F76FF] border-r-[#7F76FF] border-transparent
                    rounded-full transition-transform duration-700 ease-in-out transform origin-center rotate-45 "
                         :style="`transform: rotate({{(($this->totalPercentage()/100)*180)}}deg)`">
                    </div>

                    <!-- Cover inner circle -->
                    <div
                        class="absolute w-48 h-48 top-1/2 left-0 bg-white dark:bg-zinc-700 border-8 border-white dark:border-zinc-700">
                    </div>

                    <!-- Left Ball -->
                    <div
                        class="absolute w-2 h-2 top-1/2 left-0 transform -translate-y-1/2 bg-[#7F76FF] rounded-full"></div>

                    <!-- Right Ball (conditionally colored/gray) -->
                    <div class="absolute w-2 h-1 top-1/2 right-0 transform -translate-y-1/2 rounded-full
                        {{ $this->totalPercentage() >= 100 ? 'bg-[#7F76FF]' : 'bg-[#edebff] dark:bg-[#494962]' }}"
                         style="border-radius: 0 0 8px 8px ;">
                    </div>


                    <div class="h-1/2 w-full flex flex-col justify-end items-center">
                        <flux:text variant="strong" class="pb-2 text-3xl font-bold text-center">
                            {{ $this->totalPercentage() }}%
                        </flux:text>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col p-2.5 gap-2.5
        bg-white dark:bg-zinc-700 border border-zinc-200
        dark:border-zinc-600 rounded-lg shadow-sm">

            <flux:select
                label="Todo Status"
                size="sm"
                wire:model.live="statusFilter" class="form-select rounded border-zinc-300 dark:border-zinc-600">
                <option value="">All statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </flux:select>
        </div>
    </div>

    <div class="overflow-y-auto pb-28 max-h-[calc(100vh-20rem)] mt-3">
        @forelse($todos as $todo)
            <div x-data="{open: false}">

                <div
                    x-on:click="open = !open"
                    class="flex items-center gap-1.5 mt-4 p-2
                rounded-lg shadow-sm bg-white dark:bg-zinc-700
                hover:bg-zinc-100 dark:hover:bg-zinc-600
                border border-zinc-300 dark:border-zinc-600">
                    @if(\App\Helper\Context::isOrganization())
                        <flux:icon name="chevron-right" x-show="!open" size="sm" class=""/>
                        <flux:icon name="chevron-down" x-show="open" size="sm" class=""/>
                    @endif

                    <div class="flex flex-col gap-0.5">
                        <flux:text variant="strong" class="font-medium">{{ $todo->name }}</flux:text>
                        <flux:text variant="strong" class="text-sm dark:text-white text-zinc-700">
                            @php
                                $seconds = $todo->tracks->sum('durations') ?? 0;
                                $interval = Carbon\CarbonInterval::seconds($seconds)->cascade()->locale('en');
                            @endphp
                            Worked {{ $interval->forHumans(['parts' => 2]) }}
                        </flux:text>
                    </div>
                    <div class="ml-auto">
                        <flux:badge
                            size="sm"
                            color="{{\App\Helper\Context::isOrganization() ? $todo->status->organizationStatusColor->color->alias : $todo->status->userStatusColor->color->alias}}">
                            {{$todo->status->name}}
                        </flux:badge>
                    </div>
                </div>

                @if (\App\Helper\Context::isOrganization())
                    <div x-show="open"
                         x-cloak
                         class="mt-2 px-2 border-l border-zinc-200 dark:border-zinc-600"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                    >
                        <div class="mb-3">
                            <flux:heading level="3"
                                          class="text-md text-zinc-700 dark:text-white">
                                Assignees
                            </flux:heading>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            @forelse($todo->assignees as $assignee)
                                <div
                                    class="flex items-center gap-2 mb-2 bg-zinc-100 dark:bg-zinc-600 p-2 rounded-lg">
                                    <div class="grid grid-cols-1 gap-2 items-center w-full ">
                                        <div class="flex items-center gap-2 ">
                                            @if($assignee->avatar)
                                                <flux:avatar tooltip="{{$assignee->name}}" size="xs"
                                                             class="ring-0! ring-transparent!"
                                                             src="{{\Illuminate\Support\Facades\Storage::url($assignee->avatar->path)}}"/>
                                            @else
                                                <flux:avatar tooltip="{{$assignee->name}}" size="xs"
                                                             name="{{$assignee->name}}"
                                                             class="ring-0! ring-transparent!" color="auto"
                                                             color:seed="{{ $assignee->id }}"
                                                             initials:single/>
                                            @endif
                                            <flux:text variant="strong" class="text-sm font-medium">
                                                {{ $assignee->name }}
                                            </flux:text>
                                        </div>
                                        <flux:text variant="strong"
                                                   class=" text-sm ">
                                            Worked {{ Carbon\CarbonInterval::seconds($todo->tracks->where('user_id', $assignee->id)->sum('durations'))->cascade()->locale('en_US')->forHumans(['parts' => 2]) }}
                                        </flux:text>
                                        @php
                                            $tracksCount = $todo->tracks->where('user_id', $assignee->id)->count();
                                        @endphp
                                        <flux:text variant="strong"
                                                   class=" text-sm ">
                                            Contributed {{ $tracksCount }}
                                            Time{{ $tracksCount > 1 ? 's' : '' }}
                                        </flux:text>
                                    </div>
                                </div>
                            @empty
                                <flux:text variant="strong" class="text-sm text-zinc-500 dark:text-zinc-400">
                                    No assignees
                                </flux:text>
                            @endforelse
                        </div>
                        @php
                            $assignees = $todo->assignees->pluck('id');
                            $nonAssignees = $todo->tracks->whereNotIn('user_id', $assignees)->pluck('user_id')->unique()
                                ->map(function ($userId) {
                                    return \App\Models\User::find($userId);
                                })->filter();
                        @endphp
                        <div class="my-3">
                            <flux:heading level="3"
                                          class="text-md text-zinc-700 dark:text-white">
                                Non-Assignees
                            </flux:heading>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">


                            @forelse($nonAssignees as $assignee)
                                <div
                                    class="flex items-center gap-2 mb-2 bg-zinc-100 dark:bg-zinc-600 p-2 rounded-lg">
                                    <div class="grid grid-cols-1 gap-2 items-center w-full ">
                                        <div class="flex items-center gap-2 ">
                                            @if($assignee->avatar)
                                                <flux:avatar tooltip="{{$assignee->name}}" size="xs"
                                                             class="ring-0! ring-transparent!"
                                                             src="{{\Illuminate\Support\Facades\Storage::url($assignee->avatar->path)}}"/>
                                            @else
                                                <flux:avatar tooltip="{{$assignee->name}}" size="xs"
                                                             name="{{$assignee->name}}"
                                                             class="ring-0! ring-transparent!" color="auto"
                                                             color:seed="{{ $assignee->id }}"
                                                             initials:single/>
                                            @endif
                                            <flux:text variant="strong" class="text-sm font-medium">
                                                {{ $assignee->name }}
                                            </flux:text>
                                        </div>
                                        <flux:text variant="strong"
                                                   class=" text-sm ">
                                            Worked {{ Carbon\CarbonInterval::seconds($todo->tracks->where('user_id', $assignee->id)->sum('durations'))->cascade()->locale('en_US')->forHumans(['parts' => 2]) }}
                                        </flux:text>
                                        <flux:text variant="strong"
                                                   class=" text-sm ">
                                            Contributed {{ $todo->tracks->where('user_id', $assignee->id)->count() }}
                                            Times
                                        </flux:text>
                                    </div>
                                </div>
                            @empty
                                <flux:text variant="strong" class="text-sm text-zinc-500 dark:text-zinc-400">
                                    No non-assignees
                                </flux:text>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No todos yet for this project.</p>
        @endforelse
    </div>
</div>

