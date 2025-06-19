<div class="h-full flex flex-col justify-between gap-4">
    @if(!$assignedToMe)
        @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_CREATE))
            <flux:fieldset
                class="min-h-fit px-1 mt-2 h-8 grid grid-cols-1 sm:grid-cols-[1fr_auto_auto] items-center! gap-1.5 space-x-2">
                <flux:input
                    type="text"
                    size="sm"
                    placeholder="New Todo"
                    wire:model="name"
                    wire:keydown.enter="addTodo"
                    clearable/>
                <div class="flex items-center ">
                    <flux:switch align="left" label="Trackable" wire:model.live="trackable"/>
                </div>
                <flux:button
                    type="button"
                    size="sm"
                    wire:click="addTodo"
                    :loading="false">
                    Add Todo
                </flux:button>

            </flux:fieldset>
        @endif
    @endif

    <div class="overflow-auto h-full w-full font-lexend">

        <div
            class="grid {{(\App\Helper\Context::isOrganization())? 'grid-cols-[minmax(260px,2fr)_repeat(6,minmax(150px,1fr))]' : 'grid-cols-[minmax(260px,2fr)_repeat(5,minmax(150px,1fr))]'}} min-w-fit items-center gap-4 p-1">
            <div class="flex items-center gap-2.5">
                <flux:text variant="subtle" class="font-medium">Aa</flux:text>
                <flux:text variant="subtle" size="lg">Todo name</flux:text>
            </div>
            <div class="flex items-center gap-2.5">
                <flux:icon.timer variant="micro" class="text-neutral-400 dark:text-neutral-500"/>
                <flux:text variant="subtle" size="lg">Tracks</flux:text>
            </div>
            @if(\App\Helper\Context::isOrganization())
                <div class="flex items-center gap-2.5">
                    <flux:icon.users-round variant="micro" class="text-neutral-400 dark:text-neutral-500"/>
                    <flux:text variant="subtle" size="lg">Assignees</flux:text>
                </div>
            @endif
            <div class="flex items-center gap-2.5">
                <flux:icon.diamond variant="micro" class="text-neutral-400 dark:text-neutral-500"/>
                <flux:text variant="subtle" size="lg">Status</flux:text>
            </div>
            <div class="flex items-center gap-2.5">
                <flux:icon.circle-alert variant="micro" class="text-neutral-400 dark:text-neutral-500"/>
                <flux:text variant="subtle" size="lg">Priority</flux:text>
            </div>
            <div class="flex items-center gap-2.5">
                <flux:icon.message-circle-dashed variant="micro" class="text-neutral-400 dark:text-neutral-500"/>
                <flux:text variant="subtle" size="lg">Comments</flux:text>
            </div>
            <div class="flex items-center gap-2.5">
                <flux:icon.settings-2 variant="micro" class="text-neutral-400 dark:text-neutral-500"/>
                <flux:text variant="subtle" size="lg">Actions</flux:text>
            </div>

        </div>

        <div class="my-4 flex flex-col gap-2 min-w-[1024px]">
            @foreach($todos as $todo)
                <livewire:todos.line :todo="$todo" :assignedToMe="$assignedToMe" :key="$todo->id"/>
            @endforeach

        </div>
    </div>
    {{$todos->links()}}
</div>
