<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;

class Project extends Component
{

    public $name;
    public $description;
    public $status;
    public $end_date;
    public $priority;
    public $projectId;


    public function createProject()
    {

        \App\Models\Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => auth()->id(),
            'start_date' => now(),
            'end_date' => $this->end_date,
            'priority' => $this->priority,
        ]);

        $this->reset();
        Flux::modal('add-project')->close();
    }

    public function editProject($projectId)
    {
        $project = \App\Models\Project::find($projectId);
        $this->name = $project->name;
        $this->description = $project->description;
        $this->status = $project->status;
        $this->end_date = $project->end_date;
        $this->priority = $project->priority;
        Flux::modal('edit-project')->show();
    }

    public function updateProject($projectId)
    {
        $project = \App\Models\Project::find($projectId);
        $project->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'end_date' => $this->end_date,
            'priority' => $this->priority,
        ]);

        $this->reset();
        Flux::modal('edit-project')->close();
    }

    public function render()
    {
        $projects = \App\Models\Project::where('user_id', auth()->id())->get();
        $statuses = \App\Enums\ProjectStatus::cases();
        $priorities = \App\Enums\ProjectPriority::cases();
        return view('livewire.project', compact('projects', 'statuses', 'priorities'));
    }
}
