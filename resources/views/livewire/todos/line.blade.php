<div class="ml-{{ $todo->parent_id ? '6' : '0' }} mb-1">
    <div
        class="grid {{(\App\Helper\Context::isOrganization())? 'grid-cols-[minmax(260px,2fr)_repeat(6,minmax(150px,1fr))]' : 'grid-cols-[minmax(260px,2fr)_repeat(5,minmax(150px,1fr))]'}} min-w-fit items-center gap-4 p-1 shadow-sm hover:shadow-md transition {{ $todo->parent_id ? '' : 'border-t ' }} border-b border-gray-200/20 dark:text-neutral-100">
        <div class="flex items-center space-x-2 w-full">
            @if(!$assignedToMe)
                <button wire:click="toggleExpanded"
                        class="text-gray-400  {{ $expanded ? 'rotate-180' : '' }} {{ $todo->children->count() > 0 ? 'opacity-100' : 'opacity-40 hover:opacity-100 ' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-chevron-down-icon lucide-chevron-down">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
            @else
                <div class="w-2.5 h-4"></div>
            @endif

            <div
                class="relative group grid {{ $editingTodo ? 'grid-cols-[1fr_auto_auto]' : 'grid-cols-[1fr_auto]' }} items-center gap-2 w-full">
                @if($editingTodo)
                    <flux:input clearable type="text" size="xs" wire:model="newTodoTitle" placeholder="Todo Title"/>
                    <flux:button icon="check" variant="subtle" size="xs" wire:click="updateTodo"/>
                    <flux:button icon="x" variant="subtle" size="xs" wire:click="cancelEdit"/>
                @else

                    <p
                    @class([
                            'w-full truncate! font-medium font-lexend',
                            'text-zinc-800 dark:text-zinc-200' => $todo->status_id === \App\Models\Status::IN_PROGRESS,
                            'text-gray-400 dark:text-gray-500' => $todo->status_id === \App\Models\Status::NOT_STARTED,
                            'text-red-400 dark:text-red-300' => $todo->status_id === \App\Models\Status::STUCK,
                            'line-through text-zinc-500 dark:text-zinc-400' => $todo->status_id === \App\Models\Status::COMPLETED,
                        ])>
                        {{ $todo->name }}
                    </p>
                    @if(strlen($todo->name) >= 20)
                        <span class="pointer-events-none flex items-center justify-center w-fit whitespace-nowrap break-keep opacity-0 absolute z-50 -top-10 left-0 py-1 px-1.5
                         bg-zinc-100 border border-zinc-300 dark:bg-zinc-700 dark:border-zinc-600
                         rounded-lg group-hover:opacity-100 transition-opacity duration-200
                         text-sm text-zinc-800 dark:text-zinc-200">
                            {{ $todo->name }}
                        </span>
                    @endif
                    @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_UPDATE))
                        <flux:button icon="square-pen" size="xs" variant="subtle"
                                     wire:click="editTodo"
                                     class="opacity-30 group-hover:opacity-100 transition-opacity duration-200"/>
                    @endif
                @endif
            </div>

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
                        @if($assignee->avatar)
                            <flux:avatar tooltip="{{$assignee->name}}" size="xs" class="ring-0! ring-transparent!"
                                         src="{{\Illuminate\Support\Facades\Storage::url($assignee->avatar->path)}}"/>
                        @else
                            <flux:avatar tooltip="{{$assignee->name}}" size="xs" name="{{$assignee->name}}"
                                         class="ring-0! ring-transparent!" color="auto" color:seed="{{ $assignee->id }}"
                                         initials:single/>
                        @endif
                    @empty
                        <flux:text>No assignee yet</flux:text>
                    @endforelse
                </flux:avatar.group>

                @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_ASSIGN))

                    <flux:button square icon="user-round-cog" size="xs" variant="subtle"
                                 x-on:click="assigneeModal = true"
                    />
                    {{--Modal--}}
                    <div x-cloak x-show="assigneeModal" x-on:click.away="assigneeModal = false"
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

                            <div class="overflow-y-auto max-h-36 mt-3 mb-2">
                                @foreach($searchResults as $result)
                                    <div
                                        class="grid grid-cols-[auto_1fr_auto] gap-1.5 hover:bg-gray-100 dark:hover:bg-zinc-800 p-2 rounded-lg cursor-pointer"
                                        wire:click="addAssignee({{$result->id}})">
                                        @if($result->avatar)
                                            <flux:avatar tooltip="{{$result->name}}" size="xs"
                                                         class="ring-0! ring-transparent!"
                                                         src="{{\Illuminate\Support\Facades\Storage::url($result->avatar->path)}}"/>
                                        @else
                                            <flux:avatar tooltip="{{$result->name}}" size="xs"
                                                         name="{{$result->name}}"
                                                         class="ring-0! ring-transparent!²"
                                                         color="auto"
                                                         color:seed="{{ $result->id }}"
                                                         initials:single/>
                                        @endif
                                        <flux:heading
                                            class="whitespace-nowrap truncate!"
                                        >
                                            {{$result->name}}

                                        </flux:heading>
                                        @if($result->id === auth()->id())
                                            <flux:badge size="sm" color="amber" class="ml-1">You</flux:badge>
                                        @endif
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
                                        class="grid {{($assignee->id === auth()->id())? 'grid-cols-[auto_1fr_auto_auto]': 'grid-cols-[auto_1fr_auto]'}} items-center gap-1.5 hover:bg-gray-100 dark:hover:bg-zinc-800 p-2 rounded-lg cursor-pointer"
                                        wire:key="Assign-member-{{ $assignee->id }}-modal"
                                        wire:click="removeAssignee({{$assignee->id}})">
                                        @if($assignee->avatar)
                                            <flux:avatar tooltip="{{$assignee->name}}" size="xs"
                                                         class="ring-0! ring-transparent!"
                                                         src="{{\Illuminate\Support\Facades\Storage::url($assignee->avatar->path)}}"/>
                                        @else
                                            <flux:avatar tooltip="{{$assignee->name}}" size="xs"
                                                         name="{{$assignee->name}}"
                                                         class="ring-0! ring-transparent!²"
                                                         color="auto"
                                                         color:seed="{{ $assignee->id }}"
                                                         initials:single/>
                                        @endif
                                        <flux:heading
                                            class="whitespace-nowrap truncate!"
                                        >
                                            {{$assignee->name}}

                                        </flux:heading>
                                        @if($assignee->id === auth()->id())
                                            <flux:badge size="sm" color="amber" class="ml-1">You</flux:badge>
                                        @endif
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
                                        class="grid {{($member->id === auth()->id())? 'grid-cols-[auto_1fr_auto_auto]': 'grid-cols-[auto_1fr_auto]'}} items-center gap-1.5 hover:bg-gray-100 dark:hover:bg-zinc-800 p-2 rounded-lg cursor-pointer"
                                        wire:key="Assign-member-{{ $member->id }}-modal"
                                        wire:click="addAssignee({{$member->id}})">
                                        @if($member->avatar)
                                            <flux:avatar tooltip="{{$member->name}}" size="xs"
                                                         class="ring-0! ring-transparent!"
                                                         src="{{\Illuminate\Support\Facades\Storage::url($member->avatar->path)}}"/>
                                        @else
                                            <flux:avatar tooltip="{{$member->name}}" size="xs"
                                                         name="{{$member->name}}"
                                                         class="ring-0! ring-transparent!"
                                                         color="auto"
                                                         color:seed="{{ $member->id }}"
                                                         initials:single/>
                                        @endif
                                        <flux:heading
                                            class="whitespace-nowrap truncate!">
                                            {{$member->name}}
                                        </flux:heading>
                                        @if($member->id === auth()->id())
                                            <flux:badge size="sm" color="amber" class="ml-1">You</flux:badge>
                                        @endif
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
            <button x-on:click="statusModal = true"
                    class="cursor-pointer" aria-role="button">
                <flux:badge
                    color="{{\App\Helper\Context::isOrganization() ? $todo->status->organizationStatusColor->color->alias : $todo->status->userStatusColor->color->alias}}">
                    {{$todo->status->name}}
                </flux:badge>
            </button>
            <div x-cloak x-show="statusModal" x-on:click.away="statusModal = false"
                 class="absolute bg-white dark:bg-zinc-700 top-0 left-1/2 transform -translate-x-1/8 rounded-lg shadow-md border border-zinc-200 dark:border-zinc-500
                flex flex-wrap gap-2 p-2.5 w-full max-w-24 z-50"
            >
                @foreach($statuses->reject(fn($status) =>
                $status->id === $todo->status->id) as $status)
                    <button wire:click="updateStatus({{$status->id}})"
                            class="cursor-pointer" aria-role="button"
                            wire:key="status-{{ $status->id }}">

                        <flux:badge size="sm"
                                    color="{{\App\Helper\Context::isOrganization() ? $status->organizationStatusColor->color->alias : $status->userStatusColor->color->alias}}"

                        >{{$status->name}}</flux:badge>
                    </button>
                @endforeach
            </div>
        </div>
        <div x-data="{ priorityModal: false }"
             class="relative"
        >
            <button x-on:click="priorityModal = true"
                    class="cursor-pointer" aria-role="button">
                <flux:badge
                    color="{{\App\Helper\Context::isOrganization() ? $todo->priority->organizationPriorityColor->color->alias : $todo->priority->userPriorityColor->color->alias}}">
                    {{$todo->priority->name}}
                </flux:badge>
            </button>
            <div x-cloak x-show="priorityModal" x-on:click.away="priorityModal = false"
                 class="absolute bg-white dark:bg-zinc-700 top-0 left-1/2 transform -translate-x-1/8 rounded-lg shadow-md border border-zinc-200 dark:border-zinc-500
                flex flex-wrap gap-2 p-2.5 w-full max-w-24 z-50"
            >
                @foreach($priorities->reject(fn($priority) => $priority->id === $todo->priority->id) as $priority)
                    @if($priority->id === $todo->priority->id)
                        @continue
                    @endif
                    <button class="cursor-pointer"
                            aria-role="button"
                            wire:click="updatePriority({{$priority->id}})"
                            wire:key="status-{{ $priority->id }}"
                    >

                        <flux:badge size="sm"
                                    color="{{\App\Helper\Context::isOrganization() ? $priority->organizationPriorityColor->color->alias : $priority->userPriorityColor->color->alias}}">
                            {{$priority->name}}
                        </flux:badge>
                    </button>
                @endforeach
            </div>
        </div>

        <livewire:partials.todo.todo-comment
            :todo="$todo"
            wire:key="comment-todo-{{ $todo->id }}"
        />

        <div> {{--Actions--}}
            @if(\App\Helper\Context::isPersonal() ||  auth()->user()->can(\App\Enums\PermissionEnum::TODOS_DELETE))
                <flux:button :loading="false" :square="true" size="xs" icon="trash-2" variant="subtle"
                             wire:click="deleteTodo"
                />
            @endif

            @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_TRACK)) @endif
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
        <div class="ml-4 mt-2 mb-3 flex flex-col ">
            @if(!$assignedToMe)
                @foreach($todo->children as $child)
                    <livewire:todos.line :todo="$child" :assignedToMe="$assignedToMe" :key="$child->id"/>
                @endforeach
            @endif

            @if(!$assignedToMe)
                @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_CREATE))
                    <div class="mt-0.5 px-1 grid grid-cols-[1fr_auto_auto] items-center gap-1.5">
                        <flux:input
                            type="text"
                            size="sm"
                            placeholder="New sub-todo"
                            wire:model="newSubTodoTitle"
                            wire:keydown.enter.prevent="addSubTodo"
                            clearable/>
                        <flux:switch wire:model="trackable" align="left" label="Trackable" size="sm"/>
                        <input type="hidden" wire:model="parent_id" value="{{ $todo->id }}">
                        <flux:button
                            type="button"
                            size="sm"
                            wire:click="addSubTodo"
                            :loading="false">
                            Add
                        </flux:button>
                    </div>

                @endif
            @endif
        </div>
    @endif
</div>
