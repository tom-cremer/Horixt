<?php

namespace App\Livewire;

use App\Helper\Context;
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
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status_id' => 'nullable|exists:statuses,id',
            'priority_id' => 'nullable|exists:priorities,id',
            'color_id' => 'nullable|exists:colors,id',
            'deadline' => 'nullable|date',
        ]);

        if (Context::isOrganization()) {
            Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'user_id' => auth()->id(),
                'organization_id' => Context::getOrganizationId(),
                'status_id' => $this->status_id ?? Status::DEFAULT,
                'priority_id' => $this->priority_id ?? Priority::DEFAULT,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'deadline' => $this->deadline,
            ]);
        } else {
            Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'user_id' => auth()->id(),
                'status_id' => $this->status_id ?? Status::DEFAULT,
                'priority_id' => $this->priority_id ?? Priority::DEFAULT,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'deadline' => $this->deadline,
            ]);
        }

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
        if (Context::isOrganization()) {
            return redirect()->route('organization.projects.show', ['projectid' => $projectId, 'id' => Context::getOrganizationId()]);
        } else {
            return redirect()->route('personal.projects.show', ['projectid' => $projectId]);
        }
    }

    public function render()
    {
        $this->statuses = Status::all();
        $this->priorities = Priority::all();
        $this->colors = Color::all();

        if (Context::isOrganization()) {
            $projects = Project::where('organization_id', Context::getOrganizationId())->get();
        } else {
            $projects = Project::where('user_id', auth()->id())->where('organization_id', null)->get();
        }

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
