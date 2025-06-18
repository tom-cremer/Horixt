<?php

namespace App\Livewire\Partials;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Project;
use App\Models\Todo;

class Search extends HorixtComponent
{
    public $search = '';
    public $mode = 'global';
    public $searchResults = [];

    public $modeColors = [
        'global' => 'gray',
        'todos' => 'amber',
        'projects' => 'blue',
        'members' => 'emerald',
    ];

    public function updatedSearch()
    {
        $this->searchResults = $this->performSearch();
    }

    public function updateMode(): void
    {
        $trimmed = trim($this->search);

        if (str_starts_with($trimmed, '@todos')) {
            $this->mode = 'todos';
            $this->search = str_replace('@todos', '', $this->search);
        } elseif (str_starts_with($trimmed, '@project')) {
            $this->mode = 'projects';
            $this->search = str_replace('@project', '', $this->search);
        } /*elseif (str_starts_with($trimmed, '@member')) {
            $this->mode = 'members';
            $this->search = str_replace('@member', '', $this->search);
        }*/ else {
            return;
        }
    }

    public function removeMode()
    {
        $this->mode = 'global';
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->mode = 'global';
        $this->searchResults = [];
    }

    protected function performSearch(): array
    {
        $query = trim(preg_replace('/^@(\w+)/', '', $this->search));

        if ($this->mode === 'todos') {
            return ['todos' => Todo::search($query)->get()];
        }

        if ($this->mode === 'projects') {
            return ['projects' => Project::search($query)->get()];
        }

        /*if ($this->mode === 'members' && Context::isOrganization()) {
            $members = Context::getOrganization()->members->pluck('id')->toArray();
            return ['members' => User::search($query)->whereIn('id', $members)->get()];
        }*/

        // Global mode
        $results = [
            'todos' => Todo::search($query)->get(),
            'projects' => Project::search($query)->get(),
        ];

        /*if (Context::isOrganization()) {
            $members = Context::getOrganization()->members->pluck('id')->toArray();
            $results['members'] = User::search($query)->whereIn('id', $members)->get();
        }*/

        return $results;
    }


    public function viewTodo($todoId)
    {
        $todo = Todo::findOrFail($todoId);
        if ($todo) {

            $project = $todo->project;

            // expand task parent of the todo if it exists
            if ($todo->parent) {
                $parent = $todo->parent;
                while ($parent) {
                    session(["todo_{$parent->id}_expanded" => true]);
                    $parent = $parent->parent;
                }
            }

            // redirect to the project of the todo
            if (!empty($project)) {
                if ($project->organization_id) {
                    return redirect()->route('organization.projects.show', ['projectid' => $project->id, 'slug' => $project->organization->slug]);
                }
                return redirect()->route('personal.projects.show', ['projectid' => $project->id]);
            }
        }
    }

    public function viewProject($projectId)
    {
        $project = Project::findOrFail($projectId);
        if ($project) {
            if (Context::isOrganization() && $project->organization_id === Context::getOrganizationId()) {
                return redirect()->route('organization.projects.show', ['projectid' => $project->id, 'slug' => $project->organization->slug]);
            }
            return redirect()->route('personal.projects.show', ['projectid' => $project->id]);
        }
    }

    public function render()
    {
        return view('livewire.partials.search');
    }
}

