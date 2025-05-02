<?php

namespace App\Livewire\Todos;

use App\Helper\Context;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Todo;
use App\Traits\CreateTodo;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Line extends Component
{
    use CreateTodo;

    public Todo $todo;
    public bool $expanded = false;
    public string $newSubTodoTitle = '';

    public function mount(Todo $todo)
    {
        $this->todo = $todo;
    }


    public function toggleExpanded()
    {
        $this->expanded = !$this->expanded;
    }

    public function toggleDone()
    {
        $this->todo->is_done = !$this->todo->is_done;
        $this->todo->save();

        if ($this->todo->is_done) {
            // Mark all children done
            foreach ($this->todo->children as $child) {
                $child->update(['is_done' => true]);
            }
        }
    }

    public function showSubForm()
    {
        $this->expanded = !$this->expanded;
    }

    public function addSubTodo()
    {
        Log::info('Adding sub-todo', [
            'name' => $this->newSubTodoTitle,
            'parent_id' => $this->todo->id,
        ]);
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
        ]);

        $this->newSubTodoTitle = '';
        $this->expanded = true; // Auto expand
        $this->todo->refresh(); // Reload children
    }

    public function render()
    {
        return view('livewire.todos.line');
    }
}
