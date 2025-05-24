<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Project;

class Insights extends HorixtComponent
{

    public $projectId;
    public $project;

    public $activeTracks = [];
    public $completedToday = 0;
    public $progressPercentage = 0;

    public function mount($projectId)
    {
        $this->projectId = $projectId;

        if (Context::isOrganization()) {
            $this->project = Project::where('id', $this->projectId)
                ->where('organization_id', Context::getOrganizationId())
                ->first();

            if (!$this->project) {
                return redirect()->route('organization.projects.index', [
                    'slug' => Context::getOrganizationSlug(),
                ]);
            }
        } else {
            $this->project = Project::where('id', $this->projectId)
                ->whereNull('organization_id')
                ->where('user_id', auth()->id())
                ->first();

            if (!$this->project) {
                return redirect()->route('personal.projects.index');;
            }
        }


    }

    public function totalDuration($todo)
    {
        $timer = 0;
        foreach ($todo->tracks as $track) {
            $timer = $timer + $track->durations;
        }
        return $timer;
    }

    public function render()
    {
        return view('livewire.insights');
    }
}
