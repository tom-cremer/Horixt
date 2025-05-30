<?php

namespace App\Livewire\Todos;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Todo;
use App\Models\User;
use App\Traits\CreateTodo;

class Line extends HorixtComponent
{
    use CreateTodo;

    public Todo $todo;
    public bool $expanded = false;
    public string $newSubTodoTitle = '';
    public $trackable = true;

    public $members;

    public $priorities;
    public $statuses;

    public $search = '';
    public $searchResults = [];

    public $newTodoTitle;
    public $editingTodo = false;

    public $assignedToMe = false;

    public function mount(Todo $todo, $assignedToMe = false)
    {
        $this->assignedToMe = $assignedToMe;
        $this->todo = $todo;
        if (Context::isOrganization()) {
            $this->members = Context::getOrganization()->members;
        }
    }

    public function editTodo()
    {
        $this->editingTodo = true;
        $this->newTodoTitle = $this->todo->name;

    }

    public function updateTodo()
    {
        $this->validate([
            'newTodoTitle' => 'required|string|max:50',
        ]);
        $this->todo->update(['name' => $this->newTodoTitle]);
        $this->editingTodo = false;
        $this->reset('newTodoTitle');
    }

    public function cancelEdit()
    {
        $this->editingTodo = false;
        $this->reset('newTodoTitle');
    }

    public function toggleExpanded()
    {
        $this->expanded = !$this->expanded;
    }

    public function showSubForm()
    {
        $this->expanded = !$this->expanded;
    }

    public function addSubTodo()
    {
        $this->validate([
            'newSubTodoTitle' => 'required|string|max:50',
        ]);
        Todo::create([
            'name' => $this->newSubTodoTitle,
            'description' => '',
            'is_done' => false,
            'is_trackable' => $this->trackable,
            'status_id' => Status::DEFAULT,
            'priority_id' => Priority::DEFAULT,
            'color_id' => Color::DEFAULT,
            'organization_id' => Context::isOrganization() ? Context::getOrganizationId() : null,
            'user_id' => auth()->id(),
            'parent_id' => $this->todo->id,
            'project_id' => $this->todo->project_id,
        ]);

        $this->newSubTodoTitle = '';
        $this->expanded = true; // Auto expand
        $this->todo->refresh(); // Reload children
    }

    public function addAssignee($memberId)
    {
        $this->todo->assignees()->attach($memberId, ['assigned_by' => auth()->id()]);
    }

    public function removeAssignee($memberId)
    {
        $this->todo->assignees()->detach($memberId);
    }

    public function updatePriority($priority_id)
    {
        $this->todo->update(['priority_id' => $priority_id]);
    }

    public function updateStatus($status_id)
    {
        $this->todo->update(['status_id' => $status_id]);
    }

    public function deleteTodo()
    {
        $this->todo->delete();
        $this->dispatch('todo-deleted');
    }

    public function searchMember()
    {
        if (empty($this->search) || !is_string($this->search)) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = $this->members->filter(fn(User $member) => (stripos($member->name, $this->search) !== false) &&
            !($this->todo->assignees->contains($member->id))
        );

    }

    public function toggleTracks()
    {
        $this->todo->update(['is_trackable' => !$this->todo->is_trackable]);
    }

    public function render()
    {
        if ($this->search !== '') {
            $this->searchMember();
        }
        if ($this->search === '') {
            $this->searchResults = [];
        }
        $this->priorities = Priority::all();
        $this->statuses = Status::all();
        return view('livewire.todos.line');
    }
}
