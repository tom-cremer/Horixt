<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\Todo as Todos;
use Livewire\Component;

class Todo extends HorixtComponent
{

    public $name;
    public $todoId;

    public $completedTodos = [];

    public $priorities;
    public $statuses;
    public $colors;

    public $projectId;
    public $project;

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $this->project = Project::find($projectId);
    }

    public function createTodo()
    {
        if (Context::isOrganization()) {

            Todos::create([
                'name' => $this->name,
                'description' => $this->description ?? '',
                'is_done' => false,
                'status_id' => $this->status_id ?? Status::DEFAULT,
                'priority_id' => $this->priority ?? Priority::DEFAULT,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'user_id' => auth()->id(),
                'project_id' => $this->projectId ?? null,
                'organization_id' => Context::getOrganizationId(),
            ]);

        } else {
            Todos::create([
                'name' => $this->name,
                'description' => $this->description ?? '',
                'is_done' => false,
                'status_id' => $this->status_id ?? Status::DEFAULT,
                'priority_id' => $this->priority ?? Priority::DEFAULT,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'user_id' => auth()->id(),
                'project_id' => $this->projectId ?? null,
                'organization_id' => null,
            ]);

        }
        $this->dispatch('todoCreated');
        $this->resetExcept('projectId', 'project');
    }

    public function addTodo()
    {
        if (empty($this->name) ){
            return;
        }
        Todos::create([
            'name' => $this->name,
            'description' => '',
            'is_done' => false,
            'status_id' => Status::DEFAULT,
            'priority_id' => Priority::DEFAULT,
            'color_id' => Color::DEFAULT,
            'organization_id' => Context::isOrganization() ? Context::getOrganizationId() : null,
            'user_id' => auth()->id(),
            'project_id' => $this->projectId,
        ]);
        $this->reset(['name']);
    }


    public function updateStatus($todoId)
    {
        $todo = Todos::find($todoId);
        $todo->is_done = !$todo->is_done;
        $todo->status_id = $todo->is_done ? Status::COMPLETED : Status::IN_PROGRESS;
        $todo->save();
    }


    public function render()
    {
        $this->priorities = Priority::all();
        $this->statuses = Status::all();
        $this->colors = Color::all();

        if (Context::isOrganization()) {
            $todos = Todos::where('project_id', $this->projectId)->where('parent_id', null)->where('organization_id', Context::getOrganizationId())->with(['project', 'status', 'priority'])->get();
            $this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->where('organization_id', Context::getOrganizationId())->with(['project', 'status', 'priority'])->pluck('id')->toArray();
        } else {
            $todos = Todos::where('user_id', auth()->id())->where('project_id', $this->projectId)->where('parent_id', null)->where('organization_id', null)->with(['project', 'status', 'priority'])->get();
            $this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->where('organization_id', null)->with(['project', 'status', 'priority'])->pluck('id')->toArray();
        }

        return view('livewire.todo', [
            'todos' => $todos,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses,
            'colors' => $this->colors,
        ]);
    }
}
