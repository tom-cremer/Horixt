<div class="overflow-auto h-full w-full font-lexend">

    <div class=" grid {{(\App\Helper\Context::isOrganization())? 'grid-cols-6' : 'grid-cols-5'}} gap-2 min-w-[1024px]">
        <div class="flex items-center gap-2.5">
            <flux:text variant="subtle" class="font-medium">Aa</flux:text>
            <flux:text variant="subtle" size="lg">Todo name</flux:text>
        </div>
        <div class="flex items-center gap-2.5">
            <flux:text variant="subtle" size="lg">Tracks</flux:text>
        </div>
        @if(\App\Helper\Context::isOrganization())
            <div class="flex items-center gap-2.5">
                <flux:text variant="subtle" size="lg">Assignees</flux:text>
            </div>
        @endif
        <div class="flex items-center gap-2.5">
            <flux:text variant="subtle" size="lg">Status</flux:text>
        </div>
        <div class="flex items-center gap-2.5">
            <flux:text variant="subtle" size="lg">Priority</flux:text>
        </div>
        <div class="flex items-center gap-2.5">
            <flux:text variant="subtle" size="lg">Actions</flux:text>
        </div>

    </div>

    <div class="mt-4 mb-14 flex flex-col gap-1.5 min-w-[1024px]">

        @foreach($todos as $todo)
            <livewire:todos.line :todo="$todo" :key="$todo->id"/>
        @endforeach
        <div class="px-1 mt-2 h-8 flex items-center space-x-2">
            <flux:input
                type="text"
                size="sm"
                kbd="Enter"
                placeholder="New Todo"
                wire:model="name"
                wire:keydown.enter="addTodo"
                clearable/>
        </div>
    </div>
</div>

