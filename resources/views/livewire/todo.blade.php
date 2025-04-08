<div>
    <flux:modal.trigger name="add-todo" class="md:w-96">
        <flux:button variant="primary">Add Todo</flux:button>
    </flux:modal.trigger>

    <flux:modal name="add-todo" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a Todo</flux:heading>
                <flux:subheading>Here you can add a todo!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Todo 101" wire:model.defer="name"/>
            <flux:input label="Description" placeholder="Todo 101" wire:model.defer="description"/>

            <flux:select wire:model.defer="priority_id" placeholder="Choose Priority...">
                @foreach($priorities as $priority)
                    <flux:select.option value="{{$priority->id}}">{{$priority->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.defer="status_id" placeholder="Choose Priority...">
                @foreach($statuses as $status)
                    <flux:select.option value="{{$status->id}}">{{$status->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="createTodo" variant="primary">Add Todo</flux:button>
            </div>
        </div>
    </flux:modal>

    <div>
        @foreach($todos as $todo)
            <div
                class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm dark:bg-neutral-700 dark:text-neutral-100">

                <div class="flex items-center gap-2">
                    <flux:checkbox
                        value="{{ $todo->id }}"
                        wire:model="completedTodos"
                        wire:click="updateStatus({{ $todo->id }})"></flux:checkbox>
                    <div>
                        <h3 class="text-lg font-semibold {{ $todo->status->id === \App\Models\Status::COMPLETED ? 'line-through text-gray-400' : '' }}">
                            {{ $todo->name }}
                        </h3>
                        <p class="text-sm text-neutral-500">{{ $todo->description }}</p>
                    </div>
                </div>

                <div class="flex gap-2 items-center">
                    <span class="text-sm text-neutral-500">{{ $todo->status->name }}</span>
                    <span class="text-sm text-neutral-500">{{ $todo->priority->name }}</span>
                    <flux:button size="sm" icon="pencil" variant="ghost" inset/>
                </div>
            </div>
        @endforeach
    </div>
</div>
