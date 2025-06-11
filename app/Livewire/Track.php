<?php

namespace App\Livewire;

use App\Enums\RoleEnum;
use App\Helper\TimezoneHelper;
use App\Livewire\Component\HorixtComponent;
use App\Models\Todo;
use App\Models\Track as TrackModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $this->todo = Todo::with('tracks')->findOrFail($todo);
        $this->tracks = $this->todo->tracks()->whereNotNull('ended_at')->orderBy('started_at', 'desc')->get();
        $this->activeTrack = $this->todo->tracks()->whereNull('ended_at')->first();
    }

    public function totalDuration()
    {
        TimezoneHelper::set();
        $total = 0;
        foreach ($this->tracks as $track) {
            $total += $track->durations;
        }
        if ($this->activeTrack) {
            $total += $this->calculateDuration($this->activeTrack->started_at, now());
        }
        return $total;
    }

    public function start()
    {
        TimezoneHelper::set();

        $this->activeTrack = TrackModel::create([
            'todo_id' => $this->todo->id,
            'started_at' => now(),
            'user_id' => auth()->id(),
        ]);

        $this->dispatch('track-started');
        $this->timer = $this->totalDuration();
    }

    public function stop()
    {
        TimezoneHelper::set();

        if ($this->activeTrack) {
            $this->activeTrack->ended_at = now();
            $this->activeTrack->durations = $this->calculateDuration($this->activeTrack->started_at, $this->activeTrack->ended_at);
            $this->activeTrack->save();

            $this->dispatch('track-ended');
            $this->reset(['activeTrack']);
        }

        $this->tracks = $this->todo->tracks()->whereNotNull('ended_at')->orderBy('started_at', 'desc')->get();
        $this->timer = $this->totalDuration();
    }

    public function calculateDuration($started_at, $ended_at)
    {
        TimezoneHelper::set();

        $start = strtotime($started_at); // Convert to timestamp
        $end = strtotime($ended_at); // Convert to timestamp

        return max(0, $end - $start);
    }

    public function edit($id)
    {
        TimezoneHelper::set();

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
        TimezoneHelper::set();

        $validated = $this->validate([
            'started_at' => 'required|date_format:Y-m-d\TH:i:s|before_or_equal:ended_at',
            'ended_at' => 'required|date_format:Y-m-d\TH:i:s|after_or_equal:started_at',
        ]);

        $track = TrackModel::find($id);

        $track->started_at = Carbon::parse($validated['started_at']);
        $track->ended_at = Carbon::parse($validated['ended_at']);
        $track->durations = $this->calculateDuration($track->started_at, $track->ended_at);
        $track->save();

        $this->trackToEdit = null;
        $this->timer = $this->totalDuration();
    }

    public function deleteTrack($trackId)
    {
        TrackModel::findOrFail($trackId)->delete();
        $this->timer = $this->totalDuration();
    }

    public function toggleTrackHistory()
    {
        $this->showTrackHistory = !$this->showTrackHistory;
    }

    public function render()
    {
        $this->tracks = $this->todo->tracks()->whereNotNull('ended_at')->orderBy('started_at', 'desc')->get();
        $this->timer = $this->totalDuration();
        return view('livewire.track');
    }

}
