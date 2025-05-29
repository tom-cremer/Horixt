<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\Todo as Todos;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Todo extends HorixtComponent
{
    use WithPagination, WithoutUrlPagination;
    public $name;
    public $trackable = true;
    public $todoId;

    public $completedTodos = [];


    public $projectId;
    public $project;

    // If this is true, it will show the todos assigned to the current user
    public $assignedToMe = false;

    public function mount($projectId, $assignedToMe = false)
    {
        $this->projectId = $projectId;
        $this->project = Project::find($projectId);

    }

    public function addTodo()
    {
        if (empty($this->name) || empty(trim($this->name)) || (strlen($this->name) > 255) || (strlen(trim($this->name)) > 255)) {
            return;
        }
        Todos::create([
            'name' => $this->name,
            'description' => '',
            'is_done' => false,
            'is_trackable' => $this->trackable,
            'status_id' => Status::DEFAULT,
            'priority_id' => Priority::DEFAULT,
            'color_id' => Color::DEFAULT,
            'organization_id' => Context::isOrganization() ? Context::getOrganizationId() : null,
            'user_id' => auth()->id(),
            'project_id' => $this->projectId,
        ]);
        $this->reset(['name', 'trackable']);
    }

    #[On('todo-deleted')]
    public function render()
    {
        if (Context::isOrganization()) {
            if ($this->assignedToMe) {
                $todos = Todos::where('project_id', $this->projectId)
                    ->where('organization_id', Context::getOrganizationId())
                    ->with(['project', 'status', 'priority'])
                    ->whereHas('assignees', function ($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

            } else {
                $todos = Todos::where('project_id', $this->projectId)
                    ->where('parent_id', null)
                    ->where('organization_id', Context::getOrganizationId())
                    ->with(['project', 'status', 'priority'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
            }
            /*$this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->where('organization_id', Context::getOrganizationId())->with(['project', 'status', 'priority'])->pluck('id')->toArray();*/
        } else {
            $todos = Todos::where('user_id', auth()->id())
                ->where('project_id', $this->projectId)
                ->where('parent_id', null)
                ->where('organization_id', null)
                ->with(['project', 'status', 'priority'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
            /*$this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->where('organization_id', null)->with(['project', 'status', 'priority'])->pluck('id')->toArray();*/
        }

        return view('livewire.todo', [
            'todos' => $todos,
        ]);
    }
}
