<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use App\Models\Project;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


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
        $this->project = Project::find($this->projectId);
    }


    public function getWeeklyCompletedTodo()
    {
        return $this->project->todos()
            ->where('status_id', Status::COMPLETED)
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->startOfWeek())
            ->where('completed_at', '<=', now()->endOfWeek())
            ->orderBy('completed_at', 'asc')
            ->get();
    }

    public function formatWeeklyCompletedTodo(): array
    {
        $completedTodos = $this->getWeeklyCompletedTodo();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $formattedTodos = [];

        // Initialiser les 7 jours avec stdClass
        foreach ($days as $i => $dayName) {
            $date = $startOfWeek->copy()->addDays($i);

            $day = new \stdClass();
            $day->date = $date->format('Y-m-d');
            $day->day = $dayName;
            $day->count = 0;
            $day->percentage = 0;
            $day->todos = [];

            $formattedTodos[$date->format('Y-m-d')] = $day;
        }

        foreach ($completedTodos as $todo) {
            $dateKey = $todo->completed_at->format('Y-m-d');

            if (!isset($formattedTodos[$dateKey])) {
                continue;
            }

            $formattedTodos[$dateKey]->count++;
            $formattedTodos[$dateKey]->percentage = round(($formattedTodos[$dateKey]->count / $this->project->todos()->count()) * 100);
            $formattedTodos[$dateKey]->todos[] = (object)[
                'id' => $todo->id,
                'name' => $todo->name,
                'completed_at' => $todo->completed_at->toDateTimeString(),
            ];
        }

        return array_values($formattedTodos);
    }

    public function totalPercentage()
    {
        return round(($this->project->todos()->where('status_id', Status::COMPLETED)->whereNotNull('completed_at')->count() / $this->project->todos()->count()) * 100);

    }

    public function render()
    {
        return view('livewire.insights');
    }
}
