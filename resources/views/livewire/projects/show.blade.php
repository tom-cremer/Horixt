<div class="h-full flex flex-col overflow-clip">

    <flux:navbar>
        @foreach($features as $key => $feature)
            <flux:navbar.item wire:click="changeView('{{$key}}')" icon="{{$feature['icon']}}"
                              :current="($activeFeature === $key)">{{ucfirst($feature['label'])}}</flux:navbar.item>
        @endforeach
    </flux:navbar>
    <div class="py-3 flex-1 overflow-hidden">
        @if($activeFeature === 'todos')
            <livewire:todo :projectId="$project->id"/>
        @elseif($activeFeature === 'files')
            <livewire:file-manager/>
        @elseif($activeFeature === 'insights')
            <livewire:insights :projectId="$project->id"/>
        @elseif($activeFeature === 'settings')
            Settings
        @endif
    </div>
</div>
