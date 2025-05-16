<div class="font-lexend">
    <div class="space-y-6">

        @if($projects->count())
            <div class=" grid grid-cols-1 gap-5 xl:grid-cols-4 lg:grid-cols-2 sm:grid-cols-2 space-y-6">
                @foreach($projects as $project)
                    <div wire:click="toProject({{$project->id}})" wire:navigate
                         wire:key="project-{{$project->id}}"
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
                            @if(!\App\Helper\Context::isOrganization() || auth()->user()->can(\App\Enums\PermissionEnum::PROJECT_UPDATE))
                                <flux:button wire:click.stop="editProject({{$project->id}})">Edit</flux:button>
                            @endif
                            @if(!App\Helper\Context::isOrganization() || auth()->user()->can(\App\Enums\PermissionEnum::PROJECT_DELETE))
                                <flux:button wire:click.stop="deleteProject({{$project->id}})" variant="danger">
                                    Delete
                                </flux:button>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if(!\App\Helper\Context::isOrganization() || auth()->user()->can(\App\Enums\PermissionEnum::PROJECT_CREATE))
                    <div wire:click="openAddProjectModal" wire:key="add-project"
                        class="cursor-pointer  flex flex-col items-center justify-center gap-1.5 border-dashed border-2 border-gray-300 dark:border-zinc-500 hover:bg-gray-100 dark:hover:bg-zinc-700 transition-all duration-300 rounded-xl p-4">
                        <div class="bg-[#7F76FF] rounded-md p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </div>
                        <flux:text variant='subtle' class="font-medium">
                            Add Project
                        </flux:text>
                    </div>
                @endif
            </div>
        @endif


    </div>

    {{--Modals--}}
    <flux:modal name="add-project" class="md:w-96" >
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
    <flux:modal name="edit-project" class="md:w-96" >
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
