<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use App\Models\Project;
use Livewire\Component;

class ProjectDetails extends HorixtComponent
{

    public Project $project;

    public $features = [
        'todos' => [
            'label' => 'Todos',
            'icon' => 'list-todo',
        ],
        'files' => [
            'label' => 'Files',
            'icon' => 'folder',
        ],
        'insights' => [
            'label' => 'Insights',
            'icon' => 'chart-spline',
        ],
        'settings' => [
            'label' => 'Settings',
            'icon' => 'settings',
        ],
    ];


    public $activeFeature = 'todos';

    public function mount($projectid)
    {
        $this->project = Project::find($projectid);
    }

    public function changeView(string $key)
    {
        $this->activeFeature = $key;
    }


    public function render()
    {

        return view('livewire.projects.show', [
            'project' => $this->project
        ]);
    }
}
