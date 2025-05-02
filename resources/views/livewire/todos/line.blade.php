<div class="ml-{{ $todo->parent_id ? '6' : '0' }} mb-2">
    <div
        class="flex items-center justify-between p-2 shadow-sm hover:shadow-md transition {{ $todo->parent_id ? '' : 'border-t ' }} border-b border-gray-200/20 dark:text-neutral-100">
        <div class="flex items-center space-x-2">
            @if($todo->children->count() > 0)
                <button wire:click="toggleExpanded"
                        class="text-gray-400 hover:text-gray-600 {{ $expanded ? 'rotate-180' : '' }} transition-transform duration-200">
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
                <button wire:click="toggleExpanded"
                        class="text-gray-400 hover:text-gray-600 {{ $expanded ? 'rotate-180' : '' }} transition-transform duration-200">
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
            @endif

            <input
                type="checkbox"
                wire:click="toggleDone"
                @checked($todo->is_done)
                class="form-checkbox h-5 w-5 text-green-500"
            >

            <span class="@if($todo->is_done) line-through text-gray-400 @endif">
                {{ $todo->name }}
            </span>
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
