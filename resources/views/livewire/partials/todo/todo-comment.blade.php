<div
    x-data="{ open: false }"
>

    <flux:button icon="message-circle-plus" variant="filled" size="sm"
                 x-on:click="open = !open">
        Add Comment
    </flux:button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-x-2"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-2"
        x-on:click.away="open = false"
        x-on:keydown.escape.window="open = false"
        class="overflow-hidden max-w-xl w-full absolute top-0 right-0 bg-white border-l border-zinc-300 dark:border-zinc-600  dark:bg-zinc-800 rounded-l-lg h-screen p-5 shadow-lg z-50
        flex flex-col
        "
    >
        <div class="relative flex flex-col gap-2.5 ">
            <div class="flex items-start justify-between gap-1.5">
                <div class="flex flex-col gap-2">
                    <flux:heading size="xl">{{$todo->name}}</flux:heading>
                    <flux:text variant="subtle">Add a comment for this task</flux:text>
                </div>
                <flux:button icon="x" variant="ghost" size="xs" class=""
                             x-on:click="open = false"/>
            </div>
            <flux:separator/>

            @if(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_COMMENT))
                <div class="flex flex-col gap-3">
                    <flux:textarea

                        placeholder="Write your comment here..."
                        wire:model="content"
                        wire:keydown.enter.prevent="addComment"
                        rows="3"
                    />
                    <div class="flex justify-end">
                        <flux:button variant="filled" size="sm" wire:click="addComment">Submit</flux:button>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center flex-col gap-3">
                    <flux:text variant="subtle" class="">
                        You do not have permission to add comments.
                    </flux:text>
                </div>
            @endif

            <flux:separator/>

            <div
                class="flex flex-col gap-3 overflow-y-auto grow pr-1 {{(\App\Helper\Context::isPersonal() || auth()->user()->can(\App\Enums\PermissionEnum::TODOS_COMMENT))? "max-h-[calc(100vh-280px)]" : "max-h-[calc(100vh-170px)]" }}"
                wire:poll.60s>
                @forelse($comments as $comment)
                    <div
                        class="flex flex-col gap-2
                        bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600
                        rounded-lg py-2 shadow-xs">
                        <div class="flex items-start justify-between gap-2 px-2">
                            <div class="flex items-end gap-2 ">
                                <div class="flex items-center gap-2">
                                    <flux:tooltip content="{{$comment->user->name}}">
                                        @if($comment->user->avatar)
                                            <flux:avatar size="xs" class="ring-0! ring-transparent!"
                                                         src="{{\Illuminate\Support\Facades\Storage::url($comment->user->avatar->path)}}"/>
                                        @else
                                            <flux:avatar size="xs" name="{{$comment->user->name}}"
                                                         class="ring-0! ring-transparent!"/>
                                        @endif
                                    </flux:tooltip>

                                    <flux:text variant="strong" class="font-medium">
                                        {{$comment->user->name}}
                                    </flux:text>
                                </div>
                                <flux:text variant="subtle" class="text-xs mb-0.5">
                                    {{ $comment->created_at->diffInMinutes() < 1 ? 'Just now' : $comment->created_at->locale('en_US')->diffForHumans() }}
                                </flux:text>

                                @if($comment->updated_at != $comment->created_at )
                                    <flux:text variant="subtle" class="text-xs mb-0.5">
                                        (Edited {{ $comment->updated_at->diffInMinutes() < 1 ? 'Just now' : $comment->updated_at->locale('en_US')->diffForHumans() }})
                                    </flux:text>
                                @endif
                            </div>
                            @if($comment->user_id === auth()->user()->id)
                                <flux:dropdown>
                                    <flux:button icon="ellipsis-vertical" size="xs" variant="ghost"/>

                                    <flux:menu>
                                        <flux:menu.item icon="square-pen" wire:click="editComment({{$comment->id}})">
                                            Edit
                                        </flux:menu.item>
                                        <flux:menu.item icon="trash-2" variant="danger"
                                                        wire:click="deleteComment({{$comment->id}})">
                                            Delete
                                        </flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            @endif
                        </div>

                        <div class="px-2">
                            @if($editingCommentId === $comment->id)
                                <div>

                                    <flux:textarea
                                        wire:model="editingContent"
                                        rows="2"
                                        class="p-1.5! px-2.5!"
                                        placeholder="Edit your comment..."
                                        wire:keydown.enter.prevent="updateComment({{ $comment->id }})"/>
                                    <div class="flex justify-end my-2 gap-2">
                                        <flux:button
                                            variant="ghost"
                                            size="sm"
                                            class="ml-2"
                                            wire:click="cancelEdit"
                                            :loading="false">
                                            Cancel
                                        </flux:button>
                                        <flux:button
                                            variant="filled"
                                            size="sm"
                                            wire:click="updateComment({{ $comment->id }})">
                                            Update
                                        </flux:button>
                                    </div>
                                    @else
                                        <flux:text variant="strong" class="mt-1 ml-1.5 text-base">
                                            {{$comment->comment}}
                                        </flux:text>
                                    @endif
                                </div>
                                {{--Replies--}}
                                @if($comment->children->count() > 0)
                                    <div
                                        x-data="{ showAll: false }"
                                        class="p-2 border-y border-zinc-300 dark:border-zinc-600"
                                    >
                                        @php
                                            $replies = $comment->children()->latest()->get();
                                            $repliesCount = $replies->count();
                                        @endphp

                                        <div class="mt-2 pl-4">
                                            @foreach($replies as $index => $reply)
                                                <div
                                                    class="flex flex-col gap-2 mb-2"
                                                    x-show="showAll || {{ $index }} < 2"
                                                    x-transition
                                                >
                                                    <div class="grid grid-cols-[auto_1fr] gap-2">
                                                        <div>
                                                            <flux:tooltip content="{{ $reply->user->name }}">
                                                                @if($reply->user->avatar)
                                                                    <flux:avatar size="xs"
                                                                                 class="ring-0! ring-transparent!"
                                                                                 src="{{ \Illuminate\Support\Facades\Storage::url($reply->user->avatar->path) }}"/>
                                                                @else
                                                                    <flux:avatar size="xs"
                                                                                 name="{{ $reply->user->name }}"
                                                                                 class="ring-0! ring-transparent!"/>
                                                                @endif
                                                            </flux:tooltip>
                                                        </div>
                                                        <div class="flex flex-col gap-1">
                                                            <div
                                                                class="p-1.5 bg-zinc-100 dark:bg-zinc-600 opacity-90 rounded-lg flex items-center">
                                                                @if($editingReplyId === $reply->id)
                                                                    <flux:textarea
                                                                        wire:model="editingReplyContent"
                                                                        rows="1"
                                                                        class="p-1.5! px-2.5!"
                                                                        placeholder="Edit your reply..."
                                                                        wire:keydown.enter.prevent="updateReply"/>

                                                                @else
                                                                    <flux:text variant="strong" size="text">
                                                                        {{ $reply->comment }}
                                                                    </flux:text>
                                                                @endif
                                                            </div>
                                                            <div class="flex items-center justify-start gap-2">
                                                                <flux:text variant="subtle" class="text-xs">
                                                                    {{ $reply->created_at->diffInMinutes() < 1 ? 'Just now' : $reply->created_at->locale('en_US')->diffForHumans() }}
                                                                </flux:text>
                                                                @if($reply->user_id === auth()->user()->id)

                                                                    @if($editingReplyId === $reply->id)
                                                                        <div class="flex gap-2">
                                                                            <flux:button variant="subtle" size="xs"
                                                                                         wire:click="cancelReplyEdit">
                                                                                Cancel
                                                                            </flux:button>
                                                                            <flux:button variant="subtle" size="xs"
                                                                                         wire:click="updateReply">
                                                                                Update
                                                                            </flux:button>
                                                                        </div>
                                                                    @else
                                                                        <div class="flex gap-2">
                                                                            <flux:button variant="subtle" size="xs"
                                                                                         wire:click="editReply({{ $reply->id }})">
                                                                                Edit
                                                                            </flux:button>
                                                                            <flux:button variant="subtle" size="xs"
                                                                                         class="text-red-500! dark:text-red-400!"
                                                                                         wire:click="deleteReply({{ $reply->id }})">
                                                                                Delete
                                                                            </flux:button>
                                                                        </div>
                                                                    @endif
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($repliesCount > 2)
                                            <flux:button variant="subtle" size="xs" class="mt-2"
                                                         x-on:click="showAll = !showAll">
                                                <span x-text="showAll ? 'Show less' : 'Show all'"></span>
                                            </flux:button>
                                        @endif
                                    </div>
                                @else
                                    <div class="border-t border-zinc-300 dark:border-zinc-600"></div>
                                @endif
                                {{--Reply Input--}}
                                <div class="px-2 grid grid-cols-[auto_1fr_auto] gap-2.5">
                                    <flux:tooltip content="{{ auth()->user()->name }}" class="mt-1!">
                                        @if(auth()->user()->avatar)
                                            <flux:avatar size="xs" class="ring-0! ring-transparent!"
                                                         src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->avatar->path) }}"/>
                                        @else
                                            <flux:avatar size="xs" name="{{auth()->user()->name }}"
                                                         class="ring-0! ring-transparent!"/>
                                        @endif
                                    </flux:tooltip>

                                    <flux:textarea
                                        placeholder="Write your reply here..."
                                        size="sm"
                                        wire:model="replyContent.{{ $comment->id }}"
                                        wire:keydown.enter.prevent="replyToComment({{ $comment->id }})"
                                        rows="auto"
                                        class="p-1.5! px-2.5!"/>
                                    <flux:button
                                        variant="filled"
                                        size="sm"
                                        wire:click="replyToComment({{ $comment->id }})">
                                        Reply
                                    </flux:button>
                                </div>
                        </div>

                        @empty
                            <div class="px-2">
                                <flux:text>No comments yet</flux:text>
                            </div>
                        @endforelse
                    </div>
            </div>
        </div>
    </div>
