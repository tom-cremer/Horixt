<div class="ml-{{ $todo->parent_id ? '6' : '0' }} mb-1">
    <div
        class="grid {{(\App\Helper\Context::isOrganization())? 'grid-cols-6' : 'grid-cols-5'}} items-center gap-4 p-1 shadow-sm hover:shadow-md transition {{ $todo->parent_id ? '' : 'border-t ' }} border-b border-gray-200/20 dark:text-neutral-100">
        <div class="flex items-center space-x-2">
            @if(!$assignedToMe)
                <button wire:click="toggleExpanded"
                        class="text-gray-400  {{ $expanded ? 'rotate-180' : '' }} {{ $todo->children->count() > 0 ? 'opacity-100' : 'opacity-40 hover:opacity-100 ' }} transition-all duration-200">
                    @if($expanded)
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-chevron-down-icon lucide-chevron-down">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-chevron-down-icon lucide-chevron-down">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    @endif
                </button>
            @else
                <div class="w-2.5 h-4"> </div>
            @endif

            <flux:tooltip position="bottom" content="{{ $todo->name }}" class="truncate">
                <p class="w-full truncate! font-medium font-lexend @if($todo->is_done) line-through text-gray-400 @endif">
                    {{ $todo->name }}
                </p>
            </flux:tooltip>
        </div>
        <div>
            @if($todo->is_trackable)
                <livewire:track :todo="$todo->id" :key="'track-'.$todo->id"/>
            @endif
        </div>
        @if(\App\Helper\Context::isOrganization())
            <div x-data="{ assigneeModal: false }"

                 class="relative w-full h-full cursor-pointer
                grid grid-cols-[1fr_auto] gap-1.5 items-center"
            >

                <flux:avatar.group>
                    @forelse($todo->assignees as $assignee)
                        <flux:tooltip content="{{$assignee->name}}" position="bottom"
                                      class="w-8 h-8 text-xs">
                            <div class="p-1">
                                <flux:avatar size="xs" name="{{$assignee->name}}" initials:single color="auto"
                                             color:seed="{{ $assignee->id }}"/>
                            </div>
                        </flux:tooltip>
                    @empty
                        <flux:text>No assignee yet</flux:text>
                    @endforelse
                </flux:avatar.group>

                @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_ASSIGN->value))

                    <flux:button square icon="user-round-cog" size="xs" variant="subtle"
                                 x-on:click="assigneeModal = true"
                    />
                    {{--Modal--}}
                    <div x-show="assigneeModal" x-on:click.away="assigneeModal = false"
                         class="absolute bg-white dark:bg-zinc-700 top-10 right-0 rounded-lg shadow-md border border-zinc-200 dark:border-zinc-500
                grid grid-cols-1 grid-rows-[repeat(4,minmax(auto,1fr)] gap-1.5 p-2.5 min-w-64 max-w-72 min-h-56  z-50"
                    >
                        <div>
                            <flux:input
                                wire:model.live="search"
                                wire:keydown.enter.prevent="searchMember"
                                icon="magnifying-glass"
                                placeholder="Search"
                                clearable
                                size="sm"
                            />

                            <div class="overflow-y-auto max-h-36 my-2">
                                @foreach($searchResults as $result)
                                    <div class="">
                                        <div
                                            class="flex items-center gap-2 sm:gap-4 hover:bg-gray-100 dark:hover:bg-zinc-800 p-2 rounded-lg cursor-pointer"
                                            wire:click="addAssignee({{$result->id}})">
                                            <flux:avatar size="xs" name="{{$result->name}}" initials:single/>
                                            <flux:heading
                                                class="flex gap-0.5 items-center"
                                            >
                                                {{$result->name}}
                                                @if($result->id === auth()->id())
                                                    <flux:badge size="sm" color="amber" class="ml-1">You</flux:badge>
                                                @endif
                                            </flux:heading>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <flux:separator/>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <flux:heading level="3" size="lg">Assignees</flux:heading>
                            <div class="flex flex-col min-h-28 max-h-36 overflow-y-auto gap-1">
                                @forelse($todo->assignees as $assignee)
                                    <div
                                        class="flex items-center gap-2 sm:gap-4 hover:bg-gray-100 dark:hover:bg-zinc-800 p-2 rounded-lg cursor-pointer"
                                        wire:key="Assign-member-{{ $assignee->id }}-modal"
                                        wire:click="removeAssignee({{$assignee->id}})">
                                        <flux:avatar size="xs" name="{{$assignee->name}}" initials:single/>
                                        <flux:heading
                                            class="flex gap-0.5 items-center"
                                        >
                                            {{$assignee->name}}
                                            @if($assignee->id === auth()->id())
                                                <flux:badge size="sm" color="amber" class="ml-1">You</flux:badge>
                                            @endif
                                        </flux:heading>
                                        <flux:button square icon="x" size="xs" variant="subtle" class="ml-auto!"/>
                                    </div>
                                @empty
                                    <flux:text class="text-sm">No assignee yet</flux:text>
                                @endforelse
                            </div>
                        </div>
                        <flux:separator/>
                        <div class="flex flex-col gap-1.5">
                            <flux:heading level="3" size="lg">Members</flux:heading>
                            <div class="flex flex-col min-h-28 max-h-36 overflow-y-auto gap-1">
                                @foreach($members->reject(
                                    fn($member) => $todo->assignees->contains($member->id)
                                ) as $member)
                                    <div
                                        class="flex items-center gap-2 sm:gap-4 hover:bg-gray-100 dark:hover:bg-zinc-800 p-2 rounded-lg cursor-pointer"
                                        wire:key="Assign-member-{{ $member->id }}-modal"
                                        wire:click="addAssignee({{$member->id}})">
                                        <flux:avatar size="xs" name="{{$member->name}}" initials:single/>
                                        <flux:heading
                                            class="flex gap-0.5 items-center"
                                        >
                                            {{$member->name}}
                                            @if($member->id === auth()->id())
                                                <flux:badge size="sm" color="amber" class="ml-1">You</flux:badge>
                                            @endif
                                        </flux:heading>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div x-data="{ statusModal: false }"
             class="relative"
        >
            <flux:badge x-on:click="statusModal = true" color="zinc" class="cursor-pointer" aria-role="button" aria-pressed="false">
                {{$todo->status->name}}
            </flux:badge>
            <div x-show="statusModal" x-on:click.away="statusModal = false"
                 class="absolute bg-white dark:bg-zinc-700 top-0 left-1/2 transform -translate-x-1/8 rounded-lg shadow-md border border-zinc-200 dark:border-zinc-500
                flex flex-wrap gap-2 p-2.5 w-full max-w-24 z-50"
            >
                @foreach($statuses->reject(fn($status) =>
                $status->id === $todo->status->id) as $status)
                    <flux:badge size="sm" wire:click="updateStatus({{$status->id}})" class="cursor-pointer"
                                wire:key="status-{{ $status->id }}">{{$status->name}}</flux:badge>
                @endforeach
            </div>
        </div>
        <div x-data="{ priorityModal: false }"
             class="relative"
        >
            <flux:badge x-on:click="priorityModal = true" color="zinc" class="cursor-pointer">
                {{$todo->priority->name}}
            </flux:badge>
            <div x-show="priorityModal" x-on:click.away="priorityModal = false"
                 class="absolute bg-white dark:bg-zinc-700 top-0 left-1/2 transform -translate-x-1/8 rounded-lg shadow-md border border-zinc-200 dark:border-zinc-500
                flex flex-wrap gap-2 p-2.5 w-full max-w-24 z-50"
            >
                @foreach($priorities->reject(fn($priority) => $priority->id === $todo->priority->id) as $priority)
                    @if($priority->id === $todo->priority->id)
                        @continue
                    @endif
                    <flux:badge size="sm" wire:click="updatePriority({{$priority->id}})"
                                class="cursor-pointer">{{$priority->name}}</flux:badge>
                @endforeach
            </div>
        </div>
        <div> {{--Actions--}}
            @if(\App\Helper\Context::isPersonal() ||  auth()->user()->can(\App\Enums\PermissionEnum::TODOS_DELETE))
                <flux:button :loading="false" :square="true" size="xs" icon="trash-2" variant="subtle"
                             wire:click="deleteTodo"
                />
            @endif

            {{--TODO: Add the condition for the TODOS_TRACK !--}}
            @if($todo->is_trackable)
                <flux:tooltip content="Deactivate Tracks">
                    <flux:button :loading="false" :square="true" size="xs" icon="timer-off"
                                 variant="subtle"
                                 wire:click="toggleTracks"
                    />
                </flux:tooltip>
            @else
                <flux:tooltip content="Activate Tracks">
                    <flux:button :loading="false" :square="true" size="xs" icon="timer"
                                 variant="subtle"
                                 wire:click="toggleTracks"
                    />
                </flux:tooltip>

            @endif
        </div>
    </div>

    @if($expanded)
        <div class="ml-4 space-y-2">
            @if(!$assignedToMe)
                @foreach($todo->children as $child)
                    <livewire:todos.line :todo="$child" :assignedToMe="$assignedToMe" :key="$child->id"/>
                @endforeach
            @endif

            @if(!$assignedToMe)
                <div class="mt-2 px-1 flex items-center space-x-2">
                    <flux:input
                        type="text"
                        size="sm"
                        kbd="Enter"
                        placeholder="New sub-todo"
                        wire:model="newSubTodoTitle"
                        wire:keydown.enter="addSubTodo"
                        clearable/>
                    <flux:switch wire:model="trackable" align="left" label="Trackable" size="sm"/>
                    <input type="hidden" wire:model="parent_id" value="{{ $todo->id }}">
                </div>
            @endif
        </div>
    @endif
</div>
