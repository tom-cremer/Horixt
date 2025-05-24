<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Project;
use Livewire\Component;

class ProjectDetails extends HorixtComponent
{

    public $project;

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
        if (Context::isOrganization()) {
            $this->project = Project::where('id', $projectid)
                ->where('organization_id', Context::getOrganizationId())
                ->first();

            if (!$this->project) {
                return redirect()->route('organization.projects.index', [
                    'slug' => Context::getOrganizationSlug(),
                ]);
            }
        } else {
            $this->project = Project::where('id', $projectid)
                ->whereNull('organization_id')
                ->where('user_id', auth()->id())
                ->first();

            if (!$this->project) {
                return redirect()->route('personal.projects.index');;
            }
        }
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
