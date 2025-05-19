<div>
    <flux:modal.trigger name="edit-member-{{$member->id}}"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
        <flux:button sqare>
            <flux:icon name="pencil" size="sm"/>
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="edit-member-{{$member->id}}">
        <div>
            <flux:heading size="lg">Edit member</flux:heading>
            <flux:text class="mt-2">Edit the member's details.</flux:text>

        </div>
    </flux:modal>

</div>

