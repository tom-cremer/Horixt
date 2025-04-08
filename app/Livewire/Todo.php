<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Todo as Todos;
use Flux\Flux;
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
        Todos::create([
            'name' => $this->name,
            'description' => $this->description,
            'is_done' => false,
            'status_id' => $this->status_id ?? Status::DEFAULT,
            'priority_id' => $this->priority ?? Priority::DEFAULT,
            'color_id' => $this->color_id ?? Color::DEFAULT,
            'user_id' => auth()->id(),
            'project_id' => $this->project_id ?? null,
        ]);
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
        $todos = Todos::where('user_id', auth()->id())->with(['project', 'status', 'priority'])->get();
        $this->completedTodos = Todos::where('user_id', auth()->id())->where('is_done', true)->get()->pluck('id')->toArray();
        return view('livewire.todo', [
            'todos' => $todos,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses,
            'colors' => $this->colors,
        ]);
    }
}
