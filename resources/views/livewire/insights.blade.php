<div class="container mx-auto px-4 py-8 overflow-y-auto">
    <div class="mb-6">
        <p class="text-gray-600 dark:text-gray-400">Track your performance and analytics</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 " >
        {{-- Summary Card --}}
        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow p-6">
            <flux:heading level="3" size="lg">Overview</flux:heading>

            <div class="space-y-3">

                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Completed Today</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $project->todos()->where('is_done', true)->count() ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Progress</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $progressPercentage ?? 0 }}%</span>
                </div>
            </div>
        </div>

        {{-- Recent Activity Card --}}
        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow p-6">
            <flux:heading level="3" size="lg" >Recent Activity</flux:heading>
            <div class="space-y-4">
                @forelse($project->todos->take(3) ?? [] as $activity)
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <span class="inline-block h-2 w-2 rounded-full bg-green-500"></span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $activity->name ?? 'Activity description' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                {{ $activity->created_at?->locale('en')->diffForHumans() ?? 'Recently' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No recent activity</p>
                @endforelse
            </div>
        </div>

        {{-- Performance Metrics Card --}}{{--
        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow p-6">
            <flux:heading level="3" size="lg" >Performance</flux:heading>

            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Daily Goal Progress</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">70%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 70%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Weekly Completion Rate</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>

    <div>
        @forelse($project->todos as $todo)
            <div class="flex items-center space-x-3 mt-4">
                <div class="flex-shrink-0">
                    <flux:icon name="list-todo" size="sm"/>
                </div>
                <div class="flex-1">
                    {{$todo->name}}
                    <p class="text-xs text-gray-500 dark:text-gray-500">
                        {{ Carbon\CarbonInterval::seconds($this->totalDuration($todo) ?? 0)->cascade()->locale('en')->forHumans(['parts' => 2]) }}
                    </p>
                </div>
            </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No data available</p>
        @endforelse
    </div>
</div>
