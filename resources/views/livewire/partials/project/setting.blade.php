<div class="flex flex-col gap-6 max-w-3xl mx-auto p-6">
    <div>
        <flux:heading size="lg">Project Settings</flux:heading>
        <flux:text variant="subtle">Manage your project’s name, priority, and status.</flux:text>
    </div>
@if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::PROJECT_MANAGE))


    <form wire:submit.prevent="saveSettings" class="flex flex-col gap-5">
        <flux:input
            label="Project Name"
            placeholder="Enter a name for the project"
            wire:model.defer="editName"
        />

        <flux:input
            label="Description"
            placeholder="Describe this project..."
            rows="4"
            wire:model.defer="editDescription"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:select wire:model="editStatusId" placeholder="Choose status...">
                @foreach($statuses as $status)
                    <flux:select.option value="{{$status->id}}">{{$status->name}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="editPriorityId" placeholder="Choose Priority...">
                @foreach($priorities as $priority)
                    <flux:select.option value="{{$priority->id}}">{{$priority->name}}</flux:select.option>
                @endforeach
            </flux:select>
        </div>


        <div class="flex justify-end">
            <flux:button type="submit" variant="filled" >Save Changes</flux:button>
        </div>
    </form>
    @else
    <div>
        <flux:text variant="subtle" class="text-sm">
            Oups, You do not have permission to edit project settings.
        </flux:text>
    </div>
    @endif

</div>
