<?php

namespace App\Livewire;

use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Track extends Component
{
    public $selectedDate;
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
    public function render()
    {
        $tracks = \App\Models\Track::where('user_id', auth()->id())->
        whereDate('started_at', $this->selectedDate)->get()->sortBy('started_at');

        return view('livewire.track', compact('tracks'));
    }
}
