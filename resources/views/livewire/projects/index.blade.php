<div>
    <flux:modal.trigger name="add-project">
        <flux:button>Add Project</flux:button>
    </flux:modal.trigger>

    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Projects</flux:heading>
            <flux:subheading>Here you can see all your projects!</flux:subheading>
        </div>

        @if($projects->count())
            <div class=" grid lg:grid-cols-4 sm:grid-cols-2 gap-4 space-y-6">
                @foreach($projects as $project)
                    <div wire:click="toProject({{$project->id}})" wire:navigate
                         class="flex flex-col justify-between
                        bg-gray-50 hover:bg-gray-100 border border-gray-200
                        dark:bg-zinc-900 dark:hover:bg-zinc-800 dark:border-zinc-600
                        transition-colors duration-300 ease-in-out rounded-2xl p-4 h-full cursor-pointer">
                        <div>
                            <div>
                                <flux:heading>{{$project->name}}</flux:heading>
                                <flux:subheading>{{$project->description}}</flux:subheading>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <flux:badge color="yellow">
                                    {{$project->status->name}}
                                </flux:badge>
                                <flux:badge color="blue">
                                    {{$project->priority->name}}
                                </flux:badge>
                            </div>
                        </div>
                        <div class="ml-auto flex gap-2">
                            <flux:button wire:click.stop="editProject({{$project->id}})">Edit</flux:button>
                            <flux:button wire:click.stop="deleteProject({{$project->id}})" variant="danger">Delete
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{--Modals--}}
    <flux:modal name="add-project" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a Project</flux:heading>
                <flux:subheading>Here you can add a project!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Project 101" wire:model.defer="name"/>
            <flux:input label="Description" placeholder="Project 101" wire:model.defer="description"/>

            <flux:select wire:model="status_id" placeholder="Choose status...">
                @foreach($statuses as $status)
                    <flux:select.option value="{{$status->id}}">{{$status->name}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="priority_id" placeholder="Choose Priority...">
                @foreach($priorities as $priority)
                    <flux:select.option value="{{$priority->id}}">{{$priority->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="createProject" variant="primary">Add Project</flux:button>
            </div>
        </div>
    </flux:modal>
    <flux:modal name="edit-project" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit a Project</flux:heading>
                <flux:subheading>Here you can edit a project!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Project 101" wire:model.defer="name"/>
            <flux:input label="Description" placeholder="Project 101" wire:model.defer="description"/>

            <flux:select wire:model="status_id" placeholder="Choose status...">
                @foreach($statuses as $status)
                    <flux:select.option value="{{$status->id}}">{{$status->name}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="priority_id" placeholder="Choose Priority...">
                @foreach($priorities as $priority)
                    <flux:select.option value="{{$priority->id}}">{{$priority->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <input type="hidden" wire:model="projectId">

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="updateProject({{$projectId}})" variant="primary">Edit Project
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
