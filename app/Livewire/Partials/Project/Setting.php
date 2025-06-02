<?php

namespace App\Livewire\Partials\Project;

use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use Livewire\Component;

class Setting extends Component
{
    public $projectId;
    public $project;
    public $priorities;
    public $statuses;

    public $editName;
    public $editDescription;
    public $editStatusId;
    public $editPriorityId;


    public function mount()
    {
        $this->project = Project::findOrFail($this->projectId);
        $this->priorities = Priority::all();
        $this->statuses = Status::all();

        $this->editName = $this->project->name;
        $this->editDescription = $this->project->description;
        $this->editStatusId = $this->project->status_id;
        $this->editPriorityId = $this->project->priority_id;

    }

    public function saveSettings()
    {
        $this->validate([
            'editName' => 'required|string|max:30',
            'editDescription' => 'nullable|string|max:100',
            'editStatusId' => 'nullable|exists:statuses,id',
            'editPriorityId' => 'nullable|exists:priorities,id',
/*            'due_at' => 'nullable|date',*/
        ]);
        $this->project->update([
            'name' => $this->editName,
            'description' => $this->editDescription,
            'status_id' => $this->editStatusId,
            'priority_id' => $this->editPriorityId,
        ]);

        $this->dispatch('project-updated', name: $this->editName);
    }

    public function render()
    {
        return view('livewire.partials.project.setting');
    }
}
