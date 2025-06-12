<div class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg">

    <div class="grid grid-cols-[auto_1fr_auto] gap-2">
        <div>
            @if($author->avatar)
                <flux:avatar tooltip="{{$author->name}}" size="xs"
                             class="ring-0! ring-transparent!"
                             src="{{\Illuminate\Support\Facades\Storage::url($author->avatar->path)}}"/>
            @else
                <flux:avatar tooltip="{{$author->name}}" size="xs"
                             name="{{$author->name}}"
                             class="ring-0! ring-transparent!²"
                             color="auto"
                             color:seed="{{ $author->id }}"
                             initials:single/>
            @endif
        </div>
        <div class="flex flex-col">
            <flux:text variant="strong" class="text-sm">
                <b>{{$author->name}}</b> {{$type ? 'assigned you to a task' : 'unassigned you to a task'}}
                <b>{{ $todo->name }}</b>
            </flux:text>
            <div class="flex items-center gap-1">

                <flux:text variant="subtle">
                    @php
                        \App\Helper\TimezoneHelper::set()
                    @endphp
                    {{ $notification->created_at->diffInMinutes() < 1 ? 'Just now' : $notification->created_at->locale('en_US')->diffForHumans() }}                                        </flux:text>
                @if($unread)
                    <span class="block my-auto w-2 h-2 rounded-full bg-[#7F76FF]"></span>
                @endif
            </div>
        </div>
        <flux:dropdown class="my-auto">
            <flux:button icon="ellipsis" size="xs" variant="filled"/>

            <flux:menu>
                <flux:menu.item icon="square-arrow-out-up-right"
                                wire:click="viewTodo">
                    Go to project
                </flux:menu.item>
                <flux:menu.item icon="mail-check"
                                wire:click="markAsRead">
                    Mark as read
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</div>
