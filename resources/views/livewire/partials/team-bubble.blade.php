<div class="flex items-center justify-center ">

    @if($mode === 'members')

        @foreach($members->take(5) as $member)
            <div
                class="w-8 h-8 rounded-full border-1 border-white flex items-center justify-center ">
            <span class="text-xs font-bold font-lexend">
                {{$member->initials()}}
            </span>
            </div>
        @endforeach
        @if(count($members) >= 5)
            <div
                class="w-8 h-8 rounded-full border-1 border-white flex items-center justify-center bg-gray-200">
        <span class="text-xs font-bold font-lexend">
            +{{ count($members) - 5 }}
        </span>
            </div>
        @endif

    @else
        <div
            class="w-8 h-8 rounded-full border-1 border-white flex items-center justify-center ">
            <span class="text-xs font-bold font-lexend">
                {{$owner->initials()}}
            </span>
        </div>
    @endif
</div>
