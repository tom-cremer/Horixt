<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Priority;
use App\Models\Status;
use Carbon\Carbon;

class Dashboard extends HorixtComponent
{

    public $statuses;
    public $priorities;


    public $projects = [];

    public $topProjects = [];
    public $recentTodos = [];
    public $period = 'month'; // Default period for top projects

    public function mount()
    {
        $this->statuses = Status::all();
        $this->priorities = Priority::all();

    }


    public function getProjects()
    {
        if (Context::isPersonal()) {
            $this->projects = auth()->user()->projects()
                ->whereNull('organization_id')
                ->orderBy('created_at', 'desc')
                ->get();


        } else {
            $this->projects = Context::getOrganization()->projects()
                ->where('organization_id', Context::getOrganizationId())
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function getTopProjects($period = 'month')
    {
        return $this->projects->map(function ($project) use ($period) {
            return [
                'project' => $project,
                'totalTime' => $this->calculateProjectTotalTime($project, $period),
            ];
        })
            ->sortByDesc('totalTime')
            ->take(3)
            ->values();
    }

    private function calculateProjectTotalTime($project, $period): int
    {
        $startDate = match ($period) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            default => now()->startOfMonth(),
        };

        return $project->todos()
            ->where('status_id', Status::COMPLETED)
            ->with(['tracks' => function ($query) use ($startDate) {
                $query->where('started_at', '>=', $startDate);
            }])
            ->get()
            ->flatMap->tracks
            ->sum('durations');
    }

    public function getAugmentationProjectByMonth()
    {
        TimezoneHelper::set();

        $startOfThisMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->startOfMonth()->subSecond();

        $totalThisMonth = Context::isPersonal() ? auth()->user()->projects()
            ->whereNull('organization_id')
            ->where('created_at', '>=', $startOfThisMonth)->count() :
            Context::getOrganization()->projects()
                ->where('organization_id', Context::getOrganizationId())
                ->where('created_at', '>=', $startOfThisMonth)->count();
        $totalLastMonth = Context::isPersonal() ? auth()->user()->projects()
            ->whereNull('organization_id')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count() :
            Context::getOrganization()->projects()
                ->where('organization_id', Context::getOrganizationId())
                ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        return $totalThisMonth - $totalLastMonth;

    }

    public function getEndedProjects()
    {
        TimezoneHelper::set();

        if (Context::isPersonal()) {
            return auth()->user()->projects()
                ->where('status_id', Status::COMPLETED)
                ->orderBy('created_at', 'desc')
                ->count();
        } else {
            return Context::getOrganization()->projects()
                ->where('status_id', Status::COMPLETED)
                ->orderBy('created_at', 'desc')
                ->count();
        }

    }

    public function getRecentTodo()
    {
        TimezoneHelper::set();

        if (Context::isPersonal()) {
            return auth()->user()->todos()
                ->where(function ($query) {
                    $query->whereHas('tracks', function ($query) {
                        $query->where('created_at', '>=', now()->subDays(5))
                            ->orderBy('created_at', 'desc');
                    });
                })
                ->take(5)
                ->get();
        } else {
            return Context::getOrganization()->todos()
                ->where(function ($query) {
                    $query->whereHas('tracks', function ($query) {
                        $query->where('created_at', '>=', now()->subDays(5));
                    });
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

    }

    public function getTotalTimeAllProjects()
    {
        $startDate = match ($this->period) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            default => now()->startOfMonth(),
        };


        $totalTime = 0;
        foreach ($this->projects as $project) {
            $totalTime += $project->todos()
                ->with(['tracks' => function ($query) use ($startDate) {
                    $query->where('started_at', '>=', $startDate);
                }])
                ->get()
                ->flatMap->tracks
                ->sum('durations');
        }
        return $totalTime;
    }

    public function getTotalTodosCompletedWeekly()
    {
        TimezoneHelper::set();
        if (Context::isPersonal()) {
            return auth()->user()->todos()
                ->whereNull('organization_id')
                ->where('status_id', Status::COMPLETED)
                ->where('completed_at', '>=', now()->startOfWeek())
                ->where('completed_at', '<=', now()->endOfWeek())
                ->count();
        } else {
            return Context::getOrganization()->todos()
                ->where('organization_id', Context::getOrganizationId())
                ->where('status_id', Status::COMPLETED)
                ->whereNotNull('completed_at')
                ->where('completed_at', '>=', now()->startOfWeek())
                ->where('completed_at', '<=', now()->endOfWeek())
                ->count();
        }

    }

    public function setTimezone($timezone)
    {
        session()->put('timezone', $timezone);
    }

    public function render()
    {
        $this->getProjects();
        $this->topProjects = $this->getTopProjects();
        $this->recentTodos = $this->getRecentTodo();
        return view('dashboard');
    }
}
