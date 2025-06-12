<div class="p-4 space-y-4 " wire:poll.60s>
    <div class="flex items-center justify-between">
        <flux:heading level="2" class="font-semibold text-2xl!">Notes</flux:heading>
        <div x-data="{ colorModal: false }" class="relative">
            <flux:button variant="filled" icon="plus" size="sm" :loading="false"
                         x-on:click="colorModal = true">
                Add Note
            </flux:button>
            <div x-show="colorModal"
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 x-on:click.away="colorModal = false"
                 class="absolute top-full right-3 mt-1 grid grid-cols-4 items-center justify-center gap-2 bg-zinc-100 dark:bg-zinc-700 p-2 rounded-md z-10 shadow-md min-w-32">
                @foreach($colors as $color)
                    <button
                        wire:click="addNoteColor({{ $color->id }})"
                        x-on:click="colorModal = false"
                        class="w-6 h-6 rounded-full {{ $color->alias }} focus:ring-2 ring-offset-2 ring-zinc-500"
                        title="{{ $color->name }}">
                    </button>
                @endforeach
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-auto">
        @foreach($notes as $note)
            <div class="{{$note->color->alias}}--notes p-3 rounded-xl shadow min-h-40 flex flex-col ">

                @if($noteToEditId === $note->id)
                    <div class="mt-2">
                        <div class="flex flex-col gap-1.5">
                        <flux:input type="text" wire:model="title" size="sm" placeholder="Edit title" class="bg-white! dark:bg-white! text-zinc-800!  dark:text-zinc-800! rounded-md "/>
                        <flux:textarea wire:model="content" placeholder="Edit content"
                                       class="mt-2 bg-white! dark:bg-white! text-zinc-800! dark:text-zinc-800! rounded-md" resize="none"></flux:textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <flux:button size="sm" wire:click="cancelEdit"
                                         class="mt-2">Cancel</flux:button>
                        <flux:button variant="primary" size="sm" wire:click="updateNote"
                                      class="mt-2">Save</flux:button>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <flux:heading class="font-semibold text-xl dark:text-zinc-800">{{ $note->title }}</flux:heading>
                        <flux:dropdown position="bottom" align="end">
                            <flux:button icon="ellipsis-vertical" size="xs" />

                            <flux:menu>
                                <flux:menu.item icon="square-pen" wire:click="editNote({{$note->id}})">
                                    Edit
                                </flux:menu.item>
                                <flux:menu.item icon="trash-2" variant="danger"
                                                wire:click="deleteNote({{$note->id}})">
                                    Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                    <flux:text class="text-sm mb-2 dark:text-zinc-800">{{ $note->content }}</flux:text>
                    <flux:text variant="subtle" class="mt-auto text-xs dark:text-zinc-700">
                        @php
                            \App\Helper\TimezoneHelper::set()
                        @endphp
                        {{ $note->created_at->diffInMinutes() < 1 ? 'Just now' : $note->created_at->locale('en_US')->diffForHumans() }}
                    </flux:text>
                @endif

            </div>
        @endforeach
    </div>
</div>
