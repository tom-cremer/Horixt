<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use Flux\Flux;
use Livewire\Component;

class ProjectList extends Component
{

    public $name;
    public $description;
    public $status_id;
    public $priority_id;
    public $color_id;
    public $deadline;
    public $projectId;


    public $statuses;
    public $priorities;
    public $colors;

    public function createProject()
    {
        Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => auth()->id(),
            'status_id' => $this->status_id ?? Status::DEFAULT,
            'priority_id' => $this->priority_id ?? Priority::DEFAULT,
            'color_id' => $this->color_id ?? Color::DEFAULT,
            'deadline' => $this->deadline,
        ]);

        $this->reset();
        Flux::modal('add-project')->close();
    }

    public function editProject($projectId)
    {
        $project = Project::find($projectId);
        $this->name = $project->name;
        $this->description = $project->description;
        $this->status_id = $project->status_id;
        $this->priority_id = $project->priority_id;
        $this->color_id = $project->color_id;
        $this->deadline = $project->deadline;
        $this->projectId = $project->id;
        Flux::modal('edit-project')->show();
    }

    public function updateProject($projectId)
    {
        $project = Project::find($projectId);
        $project->update([
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->status_id ?? $project->status_id ?? Status::DEFAULT,
            'priority_id' => $this->priority_id ?? $project->priority_id ?? Priority::DEFAULT,
            'color_id' => $this->color_id ?? $project->color_id ?? Color::DEFAULT,
            'deadline' => $this->deadline,
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
        $this->statuses = Status::all();
        $this->priorities = Priority::all();
        $this->colors = Color::all();

        $projects = Project::with('status', 'priority')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.projects.index',
            [
                'projects' => $projects,
                'statuses' => $this->statuses,
                'priorities' => $this->priorities,
                'colors' => $this->colors,
            ]
        );
    }
}
