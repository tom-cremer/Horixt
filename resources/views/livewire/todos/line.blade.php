<div class="ml-{{ $todo->parent_id ? '6' : '0' }} mb-1">
    <div
        class="grid grid-cols-6 items-center gap-4 p-1 shadow-sm hover:shadow-md transition {{ $todo->parent_id ? '' : 'border-t ' }} border-b border-gray-200/20 dark:text-neutral-100">
        <div class="flex items-center space-x-2">

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


            <input
                type="checkbox"
                wire:click="toggleDone"
                @checked($todo->is_done)
                class="h-4 w-4"
            >
            <flux:tooltip position="bottom" content="{{ $todo->name }}" class="truncate">
                <p class="w-full truncate! font-medium font-lexend @if($todo->is_done) line-through text-gray-400 @endif">
                    {{ $todo->name }}
                </p>
            </flux:tooltip>
        </div>
        <div>
            <livewire:track :todo="$todo->id" :key="'track-'.$todo->id"/>
        </div>
        <div>
            /
        </div>
        <div>
            <flux:badge >{{$todo->status->name}}</flux:badge>
        </div>
        <div>
            {{$todo->priority->name}}
        </div>
        <div>
            Actions
        </div>
    </div>


    @if($expanded)
        <div class="ml-4 space-y-2">
            @foreach($todo->children as $child)
                <livewire:todos.line :todo="$child" :key="$child->id"/>
            @endforeach
            {{--Add a blank line to add a todo --}}
            <div class="mt-2  flex items-center space-x-2">
                <input
                    type="text"
                    wire:model="newSubTodoTitle"
                    wire:keydown.enter="addSubTodo"
                    class="w-full px-2 py-1 text-sm border rounded"
                    placeholder="New sub-todo..."
                >
                <input type="hidden" wire:model="parent_id" value="{{ $todo->id }}">
            </div>
        </div>
    @endif
</div>
