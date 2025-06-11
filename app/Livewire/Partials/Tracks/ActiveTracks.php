<?php

namespace App\Livewire\Partials\Tracks;

use App\Models\Track;
use Livewire\Attributes\On;
use Livewire\Component;

class ActiveTracks extends Component
{
    public $activeTracks;
    public $expanded = false;

    public function mount()
    {
        $this->handleTrackUpdate();
    }

    public function toggle()
    {
        $this->expanded = !$this->expanded;
    }

    #[On('track-started')]
    #[On('track-ended')]
    public function handleTrackUpdate()
    {
        $this->activeTracks = Track::where('user_id', auth()->id())->whereNull('ended_at')->get();
    }

    public function render()
    {
        return view('livewire.partials.tracks.active-tracks');
    }
}
