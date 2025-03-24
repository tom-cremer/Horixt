<div>
    <flux:modal.trigger name="add-project">
        <flux:button>Add Project</flux:button>
    </flux:modal.trigger>
    <flux:modal name="add-project" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a Project</flux:heading>
                <flux:subheading>Here you can add a project!</flux:subheading>
            </div>

            <flux:input label="Title" placeholder="Project 101" wire:model.defer="name"/>
            <flux:input label="Description" placeholder="Project 101" wire:model.defer="description"/>

            <flux:select wire:model="status" placeholder="Choose status...">
                @foreach($statuses as $status)
                    <flux:select.option value="{{$status}}">{{$status}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="priority" placeholder="Choose Priority...">
                @foreach($priorities as $priority)
                    <flux:select.option value="{{$priority}}">{{$priority}}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex">
                <flux:spacer/>
                <flux:button type="submit" wire:click="createProject" variant="primary">Add Project</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Projects</flux:heading>
            <flux:subheading>Here you can see all your projects!</flux:subheading>
        </div>

        @if($projects->count())
            <div class="space-y-6">
                @foreach($projects as $project)
                    <div class="flex justify-between items-center">
                        <div>
                            <flux:heading >{{$project->name}}</flux:heading>
                            <flux:subheading >{{$project->description}}</flux:subheading>
                        </div>
                        <div>
                            <flux:button wire:click="openModal('edit-project', {{$project->id}})" variant="primary">
                                Edit
                            </flux:button>
                            <flux:button wire:click="deleteProject({{$project->id}})" variant="danger">Delete
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
