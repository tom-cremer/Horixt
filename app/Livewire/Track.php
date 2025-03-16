<?php

namespace App\Livewire;

use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;

class Track extends Component
{
    public $selectedDate;
    public $trackId;
    public $title;
    public $started_at;
    public $ended_at;

    public function mount()
    {
        $this->selectedDate = Carbon::today()->toDateString(); // Stocker en format 'Y-m-d'
    }

    public function changeDate($modifier)
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDays($modifier)->toDateString();
    }

    public function addTrack()
    {
        $this->title = '';
        $this->started_at = '';
        $this->ended_at = '';
        Flux::modal('add-track')->show();
    }
    public function saveTrack()
    {
        \App\Models\Track::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'started_at' => Carbon::parse($this->selectedDate . ' ' . $this->started_at),
            'ended_at' => Carbon::parse($this->selectedDate . ' ' . $this->ended_at),
        ]);
        Flux::modal('add-track')->close();

        $this->render();
    }

    public function editTrack($trackId)
    {
        $track = \App\Models\Track::find($trackId);
        $this->title = $track->title;
        $this->started_at = $track->started_at->format('H:i');
        $this->ended_at = $track->ended_at->format('H:i');
        $this->trackId = $trackId;
        Flux::modal('edit-track')->show();
        $this->render();
    }

    public function updateTrack($trackId)
    {
        $track = \App\Models\Track::find($trackId);
        $track->update([
            'title' => $this->title,
            'started_at' => Carbon::parse($this->selectedDate . ' ' . $this->started_at),
            'ended_at' => Carbon::parse($this->selectedDate . ' ' . $this->ended_at),
        ]);
        Flux::modal('edit-track')->close();
        $this->trackId = null;
        $this->render();
    }

    public function deleteTrack($trackId)
    {
        \App\Models\Track::destroy($trackId);
        $this->trackId = null;
        $this->render();
    }

    public function render()
    {
        $tracks = \App\Models\Track::where('user_id', auth()->id())->
        whereDate('started_at', $this->selectedDate)->get()->sortBy('started_at');

        return view('livewire.track', compact('tracks'));
    }
}
