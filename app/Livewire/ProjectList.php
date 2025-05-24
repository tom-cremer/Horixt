<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use Flux\Flux;


class ProjectList extends HorixtComponent
{

    public $name;
    public $description;
    public $status_id;
    public $priority_id;
    public $color_id;
    public $deadline;
    public $projectId;
    public $projectToEdit;


    public $statuses;
    public $priorities;
    public $colors;

    public function mount()
    {
        $this->statuses = Status::all();
        $this->priorities = Priority::all();
        $this->colors = Color::all();
    }

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

        $this->resetExcept(['statuses', 'priorities', 'colors']);
        Flux::modal('add-project')->close();
    }

    public function openAddProjectModal()
    {

        Flux::modal('add-project')->show();
    }

    public function editProject($projectId)
    {
        $this->projectToEdit = Project::find($projectId);
        $this->name = $this->projectToEdit->name;
        $this->description = $this->projectToEdit->description;
        $this->status_id = $this->projectToEdit->status_id;
        $this->priority_id = $this->projectToEdit->priority_id;
        $this->color_id = $this->projectToEdit->color_id;
        $this->deadline = $this->projectToEdit->deadline;
        Flux::modal('edit-project')->show();
    }

    public function updateProject()
    {

        $this->projectToEdit->update([
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->status_id ?? $project->status_id ?? Status::DEFAULT,
            'priority_id' => $this->priority_id ?? $project->priority_id ?? Priority::DEFAULT,
        ]);

        $this->resetExcept(['statuses', 'priorities', 'colors']);
        Flux::modal('edit-project')->close();
    }


    public function deleteProject($projectId)
    {
        Project::find($projectId)->delete();
    }

    public function toProject($projectId)
    {
        if (Context::isOrganization()) {
            return redirect()->route('organization.projects.show', ['projectid' => $projectId, 'slug' => Context::getOrganizationSlug()]);
        } else {
            return redirect()->route('personal.projects.show', ['projectid' => $projectId]);
        }
    }

    public function render()
    {

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
