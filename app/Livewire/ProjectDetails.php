<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDetails extends Component
{

    public Project $project;

    public function mount($projectid)
    {
        $this->project = Project::find($projectid);
    }

    public function render()
    {

        return view('livewire.projects.show' , [
            'project' => $this->project
        ]);
    }
}
