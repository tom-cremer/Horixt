<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use Carbon\Carbon;

class Track extends HorixtComponent
{
    public $todo;

    public $activeTrack;
    public $tracks = [];
    public $showTrackHistory = false;
    public $timer;

    public function mount($todo)
    {
        $this->todo = \App\Models\Todo::with('tracks')->findOrFail($todo);
        $this->tracks = $this->todo->tracks()->orderBy('started_at', 'desc')->get();
        $this->activeTrack = $this->todo->tracks()->whereNull('ended_at')->first();
        $this->timer = $this->totalDuration();
    }

    public function totalDuration()
    {
        $this->timer = 0;
        foreach ($this->tracks as $track) {
            $this->timer = $this->timer + $track->durations;
        }
        return $this->timer;
    }

    public function incrementTimer()
    {
        if ($this->activeTrack) {
            $this->timer++;
        }
    }

    public function start()
    {
        $this->activeTrack = \App\Models\Track::create([
            'todo_id' => $this->todo->id,
            'started_at' => now(),
            'user_id' => auth()->id(),
        ]);
        $this->dispatch('track-started');
    }


    public function stop()
    {
        if ($this->activeTrack) {
            $this->activeTrack->ended_at = now();
            $this->activeTrack->durations = $this->calculateDuration($this->activeTrack->started_at, $this->activeTrack->ended_at);
            $this->activeTrack->save();
            $this->dispatch('track-ended');
            $this->reset('activeTrack');
        }

        $this->tracks = $this->todo->tracks()->orderBy('started_at', 'desc')->get();
        $this->timer = $this->totalDuration();
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

