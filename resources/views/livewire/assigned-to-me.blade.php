<div>

    <div class="flex flex-col gap-4">
        @foreach($projects as $project)
            <div class="flex flex-col gap-2">
                {{$project->name}}
                <div>
                    <livewire:todo :projectId="$project->id" :assigned-to-me="true" wire:key="assigned-{{$project->id}}"/>
                </div>
            </div>

        @endforeach



    </div>


</div>
