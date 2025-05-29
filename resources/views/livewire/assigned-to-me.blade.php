<div>

    <div class="flex flex-col gap-4">
        @foreach($projects as $project)
            <div
                x-data="{ expanded: {{ $loop->first ? 'true' : 'false' }} }"
                class="flex flex-col gap-2">
                <div class="flex items-center gap-2.5 p-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
                    <button x-on:click="expanded = !expanded"
                            :class="expanded ? 'rotate-180 text-gray-400' : 'text-gray-400'"
                            class="transition-all duration-200">
                        <svg x-show="expanded"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-chevron-down-icon lucide-chevron-down">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                        <svg x-show="!expanded"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-chevron-down-icon lucide-chevron-down">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <flux:text
                        variant="strong"
                        class="text-base font-bold!"
                    >
                        {{$project->name}}
                    </flux:text>
                    <flux:button icon="square-arrow-out-up-right"
                                 size="xs"
                                 variant="subtle"
                                 href="{{\App\Helper\Context::isOrganization() ? route('organization.projects.show', ['slug' => \App\Helper\Context::getOrganizationSlug(), 'projectid' => $project->id]): route('personal.projects.show', ['projectid' => $project->id])}}"
                    />
                </div>
                <div x-show="expanded"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform "
                     x-transition:leave-end="opacity-0 transform translate-y-2"
                     class="overflow-hidden">
                    <livewire:todo :projectId="$project->id" :assigned-to-me="true"
                                   wire:key="assigned-{{$project->id}}"/>
                </div>
            </div>

        @endforeach

    </div>


</div>
