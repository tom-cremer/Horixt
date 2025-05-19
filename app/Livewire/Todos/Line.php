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
use Livewire\Attributes\On;

class Line extends HorixtComponent
{
    use CreateTodo;

    public Todo $todo;
    public bool $expanded = false;
    public string $newSubTodoTitle = '';
    public $members;

    public $priorities;
    public $statuses;

    public $search = '';
    public $searchResults = [];

    public function mount(Todo $todo)
    {
        $this->todo = $todo;
        $this->members = Context::getOrganization()->members;
    }


    public function toggleExpanded()
    {
        $this->expanded = !$this->expanded;
    }

    public function toggleDone()
    {
        $this->todo->is_done = !$this->todo->is_done;
        $this->todo->save();

        $this->updateChildrenRecursively($this->todo, $this->todo->is_done);
    }

    public function updateChildrenRecursively($todo, $isDone)
    {
        foreach ($todo->children as $child) {
            $child->update(['is_done' => $isDone]);
            $this->dispatch('todoUpdated', $child->id);
            $this->updateChildrenRecursively($child, $isDone);
        }
    }


    #[On('todoUpdated')]
    public function refreshTodo($todoId)
    {
        if ($this->todo->id == $todoId) {
            $this->todo = Todo::find($todoId);
        }
    }

    public function showSubForm()
    {
        $this->expanded = !$this->expanded;
    }

    public function addSubTodo()
    {
        Todo::create([
            'name' => $this->newSubTodoTitle,
            'description' => '',
            'is_done' => false,
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

        $this->searchResults = $this->members->filter(fn(User $member) =>
            (stripos($member->name, $this->search) !== false) &&
            !($this->todo->assignees->contains($member->id) )
        );

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
