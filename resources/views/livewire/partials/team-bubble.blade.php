<div class="flex items-center justify-center ">

    @if($mode === 'members')

        @foreach($members->take(5) as $member)
            <flux:tooltip content="{{$member->name}}" position="bottom">
                <div
                    class="peer w-8 h-8 rounded-full border-1 bg-neutral-200 dark:bg-zinc-600  border-white flex items-center justify-center -m-0.5">
                    <span class="text-xs font-bold font-lexend ">
                        {{$member->initials()}}
                    </span>
                </div>
            </flux:tooltip>
        @endforeach
        @if(count($members) >= 5)
            <div class="w-8 h-8 rounded-full border-1 border-white flex items-center justify-center bg-gray-200">
                <span class="text-xs font-bold font-lexend">
                    +{{ count($members) - 5 }}
                </span>
            </div>
        @endif

    @else
        <flux:tooltip content="{{$owner->name}}" position="bottom">
            <div class="w-8 h-8 rounded-full border-1 bg-neutral-200 dark:bg-zinc-600 border-white flex items-center justify-center ">
                <span class="text-xs font-bold font-lexend">
                    {{$owner->initials()}}
                </span>
            </div>
        </flux:tooltip>
    @endif
</div>
