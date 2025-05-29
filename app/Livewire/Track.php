<?php

namespace App\Livewire;

use App\Enums\RoleEnum;
use App\Livewire\Component\HorixtComponent;
use App\Models\Track as TrackModel;
use Carbon\Carbon;

class Track extends HorixtComponent
{
    public $todo;

    public $activeTrack;
    public $tracks = [];
    public $showTrackHistory = false;
    public $timer;

    public $trackToEdit;

    public $started_at;
    public $ended_at;
    public $durations;

    public function mount($todo)
    {
        $this->todo = \App\Models\Todo::with('tracks')->findOrFail($todo);
        $this->tracks = $this->todo->tracks()->orderBy('started_at', 'desc')->get();
        $this->activeTrack = $this->todo->tracks()->whereNull('ended_at')->first();

    }

    public function totalDuration()
    {
        $this->timer = 0;
        foreach ($this->tracks as $track) {
            $this->timer = $this->timer + $track->durations;
        }
        if ($this->activeTrack) {
            $this->timer = $this->timer + $this->calculateDuration($this->activeTrack->started_at, now());
        }
        return $this->timer;
    }
    public function start()
    {
        self::timezone();

        $this->activeTrack = TrackModel::create([
            'todo_id' => $this->todo->id,
            'started_at' => now(),
            'user_id' => auth()->id(),
        ]);
        $this->dispatch('track-started');
    }

    public function stop()
    {
        self::timezone();

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
        self::timezone();
        $start = Carbon::createFromFormat('Y-m-d H:i:s', $started_at);
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $ended_at);
        return $start->diffInSeconds($end);
    }

    public function edit($id)
    {
        self::timezone();

        $track = TrackModel::find($id);
        if ($track->user_id != auth()->id() && !auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return;
        }
        $this->trackToEdit = $id;
        $this->started_at = Carbon::parse($track->started_at)->format('Y-m-d\TH:i:s');
        $this->ended_at = Carbon::parse($track->ended_at)->format('Y-m-d\TH:i:s');
        $this->durations = $track->durations;
    }
    public function cancelEdit()
    {
        $this->reset(['trackToEdit', 'started_at', 'ended_at', 'durations']);
    }

    public function update($id)
    {
        self::timezone();
        $validatedAttribute = $this->validate([
            'started_at' => 'required|date_format:Y-m-d\TH:i:s|before_or_equal:ended_at',
            'ended_at' => 'required|date_format:Y-m-d\TH:i:s|after_or_equal:started_at',
        ]);
        $track = TrackModel::find($id);
        $track->started_at = Carbon::parse($validatedAttribute['started_at'])->format('Y-m-d H:i:s');
        $track->ended_at = Carbon::parse($validatedAttribute['ended_at'])->format('Y-m-d H:i:s');
        $track->durations = $this->calculateDuration($track->started_at, $track->ended_at);
        $track->save();
        $this->trackToEdit = null;
    }
    public function deleteTrack($trackId)
    {
        $track = TrackModel::findOrFail($trackId);
        $track->delete();
        $this->timer = $this->totalDuration();
    }

    public function toggleTrackHistory()
    {
        $this->showTrackHistory = !$this->showTrackHistory;
    }

    public function render()
    {
        $this->tracks = $this->todo->tracks()->orderBy('started_at', 'desc')->get();
        $this->timer = $this->totalDuration();
        return view('livewire.track');
    }

    public function timezone()
    {
        date_default_timezone_set(session('timezone', 'UTC'));
    }
}

