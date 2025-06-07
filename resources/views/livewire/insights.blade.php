<div class=" overflow-y-auto h-full font-lexend">
    <div class="flex items-center justify-between ">
        Sub-Menu

    </div>

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
                                <div class="mt-auto w-full bg-[#7F76FF] rounded-sm transition-[height] duration-500 ease-in-out"
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

        {{--<div class="flex flex-col p-2.5 gap-2.5
        bg-white dark:bg-zinc-700 border border-zinc-200
        dark:border-zinc-600 rounded-lg shadow-sm">
            <div class="flex flex-col gap-0.5">
                <flux:heading class="text-lg font-bold">Global overview</flux:heading>
            </div>
            <div class="flex justify-center items-center h-28 overflow-hidden">

                <div x-data="{
                    progress: 0,
                    init() {
                        this.progress = {{$this->totalPercentage()}};
                    }}"
                    class="relative h-48 w-48 overflow-hidden transform translate-y-1/4">
                    <div class="absolute h-48 w-48 top-0 left-0 border-8 border-[#7F76FF]/15 rounded-full">

                    </div>
                    <div class="absolute h-48 w-48 top-0 left-0 border-8 border-b-[#7F76FF] rounded-full "
                    style=" transform: rotate({{ ($this->totalPercentage() / 100) * 360 }}deg); ">

                    </div>
                    <div
                        class="absolute w-48 h-48 top-1/2 left-0  bg-white dark:bg-zinc-700 border-8 border-white dark:border-zinc-700">
                    </div>

                    --}}{{--Rounded ball left--}}{{--
                    <div class="absolute  w-2 h-2 top-1/2 left-0 transform -translate-y-1/2  bg-[#7F76FF] rounded-full">
                    </div>
                    --}}{{--Rounded ball left--}}{{--
                    <div class="absolute w-2 h-2 top-1/2 right-0 transform -translate-y-1/2 bg-[#7F76FF]  rounded-full">
                    </div>
                </div>

            </div>

        </div>--}}
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

    </div>

</div>
{{-- <div>
        @forelse($project->todos as $todo)
            <div class="flex items-center space-x-3 mt-4">
                <div class="flex-shrink-0">
                    <flux:icon name="list-todo" size="sm"/>
                </div>
                <div class="flex-1">
                    {{$todo->name}}
                    <p class="text-xs text-gray-500 dark:text-gray-500">
                        {{ Carbon\CarbonInterval::seconds($todo->tracks()->sum('durations') ?? 0)->cascade()->locale('en')->forHumans(['parts' => 2]) }}
                    </p>
                </div>
            </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No data available</p>
        @endforelse
    </div>--}}
