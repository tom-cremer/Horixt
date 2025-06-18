<div class="h-full flex flex-col overflow-clip">

    <flux:navbar class="hidden sm:flex">
        @foreach($features as $key => $feature)
            <flux:navbar.item wire:click="changeView('{{$key}}')" icon="{{$feature['icon']}}"
                              :current="($activeFeature === $key)">{{ucfirst($feature['label'])}}</flux:navbar.item>
        @endforeach
    </flux:navbar>
    <flux:navlist class="flex sm:hidden">
        @foreach($features as $key => $feature)
            <flux:navlist.item wire:click="changeView('{{$key}}')" icon="{{$feature['icon']}}"
                              :current="($activeFeature === $key)">{{ucfirst($feature['label'])}}</flux:navlist.item>
        @endforeach
    </flux:navlist>
    <div class="py-2.5 flex-1 overflow-hidden">
        @if($activeFeature === 'todos')
            <livewire:todo :projectId="$project->id"/>
        @elseif($activeFeature === 'files')
            <livewire:file-manager/>
        @elseif($activeFeature === 'insights')
            <livewire:insights :projectId="$project->id"/>
        @elseif($activeFeature === 'briefs')
            <livewire:note-board :projectId="$project->id"/>
        @elseif($activeFeature === 'settings')
            <livewire:partials.project.setting :projectId="$project->id"/>
        @endif
    </div>
</div>
