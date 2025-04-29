<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class Track extends Component
{
    public $todo;
    public $activeTrack;
    public $tracks = [];
    public $showTrackHistory = false;
    public function mount($todo)
    {
        $this->todo = \App\Models\Todo::with('tracks')->findOrFail($todo);
        $this->activeTrack = $this->todo->tracks()->whereNull('ended_at')->first();
    }

    public function start()
    {
        $this->activeTrack = \App\Models\Track::create([
            'todo_id' => $this->todo->id,
            'started_at' => now(),
            'user_id' => auth()->id(),
        ]);
    }

    public function stop()
    {
        if ($this->activeTrack) {
            $this->activeTrack->ended_at = now();
            $this->activeTrack->durations = $this->calculateDuration($this->activeTrack->started_at, $this->activeTrack->ended_at);
            $this->activeTrack->save();
            $this->activeTrack = null;
        }
    }

    public function calculateDuration($started_at, $ended_at)
    {
        $start = Carbon::parse($started_at);
        $end = Carbon::parse($ended_at);
        return $start->diffInSeconds($end);
    }

    public function deleteTrack($trackId)
    {
        $track = \App\Models\Track::findOrFail($trackId);
        $track->delete();
    }

    public function toggleTrackHistory()
    {
        $this->showTrackHistory = !$this->showTrackHistory;
    }


    public function render()
    {
        $this->tracks = $this->todo->tracks()->orderBy('started_at', 'desc')->get();
        return view('livewire.track');
    }
}

