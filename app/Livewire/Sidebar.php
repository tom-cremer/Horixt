<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;

class Sidebar extends HorixtComponent
{
    #[Session(key: 'collapsed')]
    public $collapsed = false;

    public $organizations = [];

    public $projects;
    public $favProjects;

    #[Session(key: 'favTray')]
    public $favTray = false;
    #[Session(key: 'projectTray')]
    public $projectTray = false;


    public function mount()
    {
        $this->organizations = auth()->user()->organizations;
        $this->loadProjects();
    }

    public function toggle()
    {
        $this->dispatch('sidebar-toggle');
        return $this->collapsed = !$this->collapsed;
    }

    public function toggleFavTray()
    {
        $this->favTray = !$this->favTray;
    }

    public function toggleTray()
    {
        $this->projectTray = !$this->projectTray;
    }

    #[On('organization-created')]
    public function getOrganizations()
    {
        $this->organizations = auth()->user()->organizations;
    }

    #[On('refresh-projects')]
    #[On('remove-favorites')]
    #[On('add-favorites')]
    public function loadProjects()
    {
        Log::info('Loading projects');
        $this->projects = [];
        $this->favProjects = [];
        if (Context::isOrganization()) {
            $this->projects = Context::getOrganization()->projects()->latest()->take(5)->get();
            $this->favProjects = auth()->user()->favoriteProjects()
                ->where('organization_id', Context::getOrganizationId())
                ->latest()
                ->get();
        } else {
            $this->projects = auth()->user()->projects()->whereNull('organization_id')
                ->latest()->take(5)->get();
            $this->favProjects = auth()->user()->favoriteProjects()
                ->whereNull('organization_id')
                ->latest()
                ->get();
        }
    }


    public function render()
    {

        $collapsed = $this->collapsed;
        return view('livewire.sidebar', compact('collapsed'));
    }
}
