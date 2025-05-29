<div class="flex items-center justify-center ">

    @if($mode === 'members')
        <flux:avatar.group class="ring-0! ring-transparent!">
            @foreach($members->take(5) as $member)
                @if($member->avatar)
                    <flux:avatar tooltip="{{$member->name}}" size="sm" class="ring-0! ring-transparent!"
                                 src="{{\Illuminate\Support\Facades\Storage::url($member->avatar->path)}}"/>
                @else
                    <flux:avatar tooltip="{{$member->name}}" size="sm" name="{{$member->name}}" class="ring-0! ring-transparent!"/>
                @endif
            @endforeach
            @if(count($members) >= 5)
                <flux:avatar>{{count($members) - 5}}+</flux:avatar>
            @endif
        </flux:avatar.group>

    @else
        @if($owner->avatar)
            <flux:avatar tooltip="{{$owner->name}}" size="sm"
                         src="{{\Illuminate\Support\Facades\Storage::url($owner->avatar->path)}}"/>
        @else
            <flux:avatar tooltip="{{$owner->name}}" size="sm" name="{{$owner->name}}"/>
        @endif

    @endif
</div>
