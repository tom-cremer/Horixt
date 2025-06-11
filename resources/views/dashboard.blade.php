<div class="flex flex-col h-full w-full overflow-hidden"
     x-data="{ timezone: Intl.DateTimeFormat().resolvedOptions().timeZone }"
     x-init="$wire.setTimezone(timezone)">

    {{-- Greeting --}}
    <div class="mb-4">

        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">
            {{ \App\Helper\GreetingHelper::getGreeting() }}, {{ auth()->user()->name }}
        </h2>
    </div>

    {{-- Bento Grid --}}
    <div class="flex flex-col justify-start items-start gap-4 overflow-y-auto pr-1 pb-2">

        <div class="grid grid-cols-2 sm:grid-cols-2  lg:grid-cols-4 gap-4 w-full">

            {{-- Total Projects --}}
            <div
                class="min-h-20 flex flex-col gap-1.5 shadow-md rounded-xl p-2.5"
                style="background: linear-gradient(-135deg, #a39cff 0%, #8a83f2 100%);">
                <flux:text variant="strong" class="text-lg font-semibold text-white">Total Projects</flux:text>
                <div class="flex flex-col gap-2 justify-between h-full">
                    <flux:text variant="strong" class="ml-1 text-4xl font-bold text-white">
                        {{ $projects->count() }}
                    </flux:text>

                    @if ($this->getAugmentationProjectByMonth() > 0)
                        <p class="text-green-400  text-xs font-normal mt-auto"><span
                                class="border-[1.5px] min-w-2 max-w-fit  text-center border-green-400 px-[3px] text-xs font-medium rounded-md">+{{ $this->getAugmentationProjectByMonth() }}</span>
                            Increased this month</p>
                    @elseif ($this->getAugmentationProjectByMonth() < 0)
                        <p class="text-red-300 text-xs font-normal mt-auto"><span
                                class="border-[1.5px] min-w-2 max-w-fit  text-center border-red-300 px-[3px] text-xs font-medium rounded-md">{{ $this->getAugmentationProjectByMonth() }}</span>
                            Decreased this month</p>
                    @else
                        <p class="text-gray-600/80 font-normal text-xs mt-auto"><span
                                class="border-[1.5px] min-w-2 max-w-fit  text-center border-gray-600/80 px-[3px] text-xs font-medium rounded-md">+{{ $this->getAugmentationProjectByMonth() }}</span>
                            this month</p>
                    @endif
                </div>
            </div>
            <div
                class="min-h-20 flex flex-col gap-1.5 shadow-md rounded-xl p-2.5
                bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600">
                <flux:text variant="strong" class="text-lg font-semibold">Completed Projects</flux:text>
                <div class="flex flex-col gap-2 justify-between h-full min-h-[64px]">
                    <flux:text variant="strong" class="ml-1 text-3xl font-bold">
                        {{ $this->getEndedProjects() }}
                    </flux:text>
                </div>
            </div>
            <div
                class="min-h-20 flex flex-col gap-1.5 shadow-md rounded-xl p-2.5
                bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600">

                <flux:text variant="strong" class="text-lg font-semibold">Total Time</flux:text>


                <div class="flex flex-col gap-2 justify-between h-full min-h-[64px]">
                    <flux:text variant="strong" class="ml-1 text-3xl font-bold">
                        @php
                            $interval = \Carbon\CarbonInterval::seconds($this->getTotalTimeAllProjects())->cascade();
                            $h = floor($interval->totalHours);
                            $m = $interval->minutes;
                        @endphp
                        @if($h > 0)
                            {{ $h }} hour{{ $h !== 1 ? 's' : '' }}
                        @else
                            {{ $m }} minute{{ $m !== 1 ? 's' : '' }}
                        @endif
                    </flux:text>
                    <flux:text variant="subtle" class="text-xs ">This represents the time across all projects</flux:text>
                </div>

            </div>
            <div
                class="min-h-20 flex flex-col gap-1.5 shadow-md rounded-xl p-2.5
                bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600">
                <flux:text variant="strong" class="text-lg font-semibold">Completed Todos</flux:text>
                <div class="flex flex-col gap-2 justify-between h-full min-h-[64px]">
                    <flux:text variant="strong" class="ml-1 text-3xl font-bold">
                        {{ $this->getTotalTodosCompletedWeekly() }}
                    </flux:text>
                    <flux:text variant="subtle" class="text-xs ">This represents the completed todos across all projects this week</flux:text>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3  gap-4 w-full">

            <div class="flex flex-col gap-3">


                @php
                    $podium = [
                        1 => $topProjects[1] ?? null, // 2nd left
                        0 => $topProjects[0] ?? null, // 1st center
                        2 => $topProjects[2] ?? null, // 3rd right
                    ];

                    $heights = [
                        0 => 'h-30', // 1
                        1 => 'h-22', // 2
                        2 => 'h-16', // 3
                    ];

                @endphp
                {{-- Top 3 Projects Podium --}}
                <div
                    class=" flex flex-col gap-4 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 shadow-md rounded-xl p-2.5 min-h-52 max-h-64 ">
                    <flux:text variant="strong" class="text-lg font-semibold">Top 3 Projects</flux:text>
                    <div class="grid grid-cols-3 justify-end items-end gap-4 w-full h-full mx-auto ">
                        @foreach($podium as $index => $item)
                            @if($item)
                                <div class="flex flex-col items-center justify-end">
                                    <div
                                        class="w-full rounded-t-xl rounded-b-sm {{ $heights[$index] }} bg-[#7F76FF] flex items-center justify-center text-white text-sm font-bold shadow">
                                        {{ $index === 0 ? '1' : ($index === 1 ? '2' : '3') }}
                                    </div>
                                    <div class="mt-2 text-center">
                                        <flux:tooltip content="{{ $item['project']->name }}">
                                            <flux:text variant="strong"
                                                       class="text-sm font-semibold truncate max-w-24">{{ $item['project']->name }}</flux:text>
                                        </flux:tooltip>
                                        <div class="text-xs text-zinc-500">
                                            @php
                                                $interval = \Carbon\CarbonInterval::seconds($item['totalTime'])->cascade();
                                                $h = floor($interval->totalHours);
                                                $m = $interval->minutes;
                                            @endphp
                                            {{ $h }}h{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{--<div
                    class=" flex flex-col gap-4 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 shadow-md rounded-xl p-2 min-w-60 min-h-52">

                    <flux:text variant="strong" class="text-lg font-semibold">Week Recap</flux:text>
                    <div class="flex flex-col gap-2">
                        @foreach($weekRecap as $day)
                            <div class="flex justify-between items-center gap-2 bg-zinc-50 dark:bg-zinc-600 rounded-md p-2 hover:bg-zinc-100 dark:hover:bg-zinc-500 transition">
                                <flux:text variant="strong" class="text-sm font-semibold">
                                    {{ $day->day }}
                                </flux:text>
                                <flux:text variant="subtle" class="text-xs text-zinc-500">
                                    {{ $day->count }} Todos
                                </flux:text>
                            </div>
                        @endforeach
                </div>--}}
            </div>
            <div class="flex flex-col gap-3">

                {{-- Recent Projects --}}
                <div
                    class=" flex flex-col gap-4 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 shadow-md rounded-xl p-2 min-w-60 min-h-52">
                    <flux:text variant="strong" class="text-lg font-semibold">Recent Projects</flux:text>
                    <div class="flex flex-col gap-2">
                        @foreach($projects->take(5) as $project)
                            <a
                                href="{{ \App\Helper\Context::isOrganization() ? route('organization.projects.show', ['slug' => \App\Helper\Context::getOrganizationSlug(), 'projectid' => $project->id]) : route('personal.projects.show', ['projectid' => $project->id]) }}"
                                wire:navigate
                                class="flex justify-between items-center gap-2 bg-zinc-50 dark:bg-zinc-600 rounded-md p-2 hover:bg-zinc-100 dark:hover:bg-zinc-500 transition">
                                <flux:tooltip content="{{ $project->name }}">
                                    <flux:text variant="strong" class="text-sm font-semibold truncate max-w-full">
                                        {{ $project->name }}
                                    </flux:text>
                                </flux:tooltip>
                                <flux:icon icon="square-arrow-out-up-right" variant="micro" class="text-zinc-400"/>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="flex flex-col gap-3">
                {{--Recent Todo--}}
                <div
                    class="flex flex-col gap-4 p-2 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 shadow-md rounded-xl min-w-60 min-h-52 ">
                    <flux:text variant="strong" class="text-lg font-semibold">Recent Todos</flux:text>
                    <div class="flex flex-col gap-2">
                        @foreach($recentTodos as $todo)
                            <div
                                class=" flex justify-between sm:grid sm:grid-cols-[1fr_1fr_auto] w-full items-center gap-2 border-t border-t-zinc-200 dark:border-t-zinc-600 p-2 ">
                                <flux:tooltip content="{{ $todo->name }}">
                                    <flux:text variant="strong"
                                               class="text-sm font-semibold truncate w-full sm:max-w-20">
                                        {{ $todo->name }}
                                    </flux:text>
                                </flux:tooltip>

                                <div class="hidden sm:block">
                                    <livewire:track :todo="$todo->id" :modal="false" :key="'track-'.$todo->id"/>
                                </div>

                                <flux:button icon="square-arrow-out-up-right" variant="filled" size="xs"
                                             :loading="false"
                                             href="{{\App\Helper\Context::isOrganization() ? route('organization.projects.show', ['projectid' => $todo->project->id, 'slug' => \App\Helper\Context::getOrganizationSlug()]): route('personal.projects.show', ['projectid' => $todo->project] )}}"
                                             wire:navigate/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
