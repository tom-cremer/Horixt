<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Todo as Todos;
use Livewire\Component;

class Todo extends Component
{

    public $name;
    public $description;
    public $is_done;
    public $priority_id;
    public $status_id;
    public $color_id;

    public $todoId;

    public $completedTodos = [];

    public $priorities;
    public $statuses;
    public $colors;


    public function createTodo()
    {
        if (Context::isOrganization()) {

            Todos::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_done' => false,
                'status_id' => $this->status_id ?? Status::DEFAULT,
                'priority_id' => $this->priority ?? Priority::DEFAULT,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'user_id' => auth()->id(),
                'project_id' => $this->project_id ?? null,
                'organization_id' => Context::getOrganizationId(),
            ]);

        } else {
            Todos::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_done' => false,
                'status_id' => $this->status_id ?? Status::DEFAULT,
                'priority_id' => $this->priority ?? Priority::DEFAULT,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'user_id' => auth()->id(),
                'project_id' => $this->project_id ?? null,
                'organization_id' => null,
            ]);
        }
        $this->reset();
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
            $todos = Todos::where('user_id', auth()->id())->where('organization_id', Context::getOrganizationId())->with(['project', 'status', 'priority'])->get();
            $this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->where('organization_id', Context::getOrganizationId())->with(['project', 'status', 'priority'])->get();
        } else {
            $todos = Todos::where('user_id', auth()->id())->where('organization_id', null)->with(['project', 'status', 'priority'])->get();
            $this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->where('organization_id')->with(['project', 'status', 'priority'])->get();
        }

        return view('livewire.todo', [
            'todos' => $todos,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses,
            'colors' => $this->colors,
        ]);
    }
}
