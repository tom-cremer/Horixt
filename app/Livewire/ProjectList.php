<?php

namespace App\Livewire;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use App\Models\Project;
use Flux\Flux;
use Livewire\Component;

class ProjectList extends Component
{

    public $name;
    public $description;
    public $status;
    public $end_date;
    public $priority;
    public $projectId;


    public function createProject()
    {
        Project::create([
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
        $project = Project::find($projectId);
        $this->name = $project->name;
        $this->description = $project->description;
        $this->status = $project->status;
        $this->end_date = $project->end_date;
        $this->priority = $project->priority;
        $this->projectId = $project->id;
        Flux::modal('edit-project')->show();
    }

    public function updateProject($projectId)
    {
        $project = Project::find($projectId);
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

    public function deleteProject($projectId)
    {
        Project::find($projectId)->delete();
    }

    public function toProject($projectId)
    {
        return redirect()->route('projects.show', [$projectId]);
    }

    public function render()
    {
        $projects = Project::where('user_id', auth()->id())->get();
        $statuses = ProjectStatus::cases();
        $priorities = ProjectPriority::cases();
        return view('livewire.projects.index', compact('projects', 'statuses', 'priorities'));
    }
}
