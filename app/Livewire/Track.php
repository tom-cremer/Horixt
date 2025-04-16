<?php

namespace App\Livewire;

use App\Helper\Context;
use App\Models\Color;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;

class Track extends Component
{
    public $selectedDate;
    public $trackId;
    public $title;
    public $description;
    public $started_at;
    public $ended_at;
    public $project_id;
    public $color_id;

    public $colors;

    public $showTrackModal = false;
    public function mount()
    {
        $this->selectedDate = Carbon::today()->toDateString(); // Stocker en format 'Y-m-d'
        $this->colors = Color::all();
    }

    public function showTrack($track_id)
    {
        $track = \App\Models\Track::find($track_id);
        if ($track) {
            $this->trackId = $track->id;
            $this->title = $track->title;
            $this->description = $track->description;
            $this->started_at = $track->started_at;
            $this->ended_at = $track->ended_at;
            $this->project_id = $track->project_id;
            $this->color_id = $track->color_id;
        }
        $this->showTrackModal = true;
    }

    public function changeDate($modifier)
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDays($modifier)->toDateString();
    }

    public function createTrack()
    {
        if (Context::isOrganization()) {
            $this->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'started_at' => 'required|date',
                'ended_at' => 'nullable|date|after_or_equal:started_at',
                'project_id' => 'nullable|exists:projects,id',
                'color_id' => 'nullable|exists:colors,id',
            ]);

            \App\Models\Track::create([
                'title' => $this->title,
                'description' => $this->description,
                'started_at' => $this->started_at,
                'ended_at' => $this->ended_at,
                'user_id' => auth()->id(),
                'project_id' => $this->project_id,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'organization_id' => Context::getOrganizationId(),
            ]);
        } else {
            $this->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'started_at' => 'required',
                'ended_at' => 'nullable',
                'project_id' => 'nullable|exists:projects,id',
                'color_id' => 'nullable|exists:colors,id',
            ]);

            \App\Models\Track::create([
                'title' => $this->title,
                'description' => $this->description,
                'started_at' => $this->started_at,
                'ended_at' => $this->ended_at,
                'user_id' => auth()->id(),
                'project_id' => $this->project_id,
                'color_id' => $this->color_id ?? Color::DEFAULT,
                'organization_id' => null,
            ]);

        }
        Flux::modal('add-track')->close();
        $this->resetExcept(['selectedDate', 'colors']);
        $this->render();
    }

    public function editTrack($trackId)
    {
        $track = \App\Models\Track::find($trackId);
        if ($track) {
            $this->trackId = $track->id;
            $this->title = $track->title;
            $this->description = $track->description;
            $this->started_at = $track->started_at;
            $this->ended_at = $track->ended_at;
            $this->project_id = $track->project_id;
            $this->color_id = $track->color_id;
        }
        Flux::modal('edit-track')->show();

    }

    public function updateTrack()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'project_id' => 'nullable|exists:projects,id',
            'color_id' => 'nullable|exists:colors,id',
        ]);

        $track = \App\Models\Track::find($this->trackId);
        if ($track) {
            $track->update([
                'title' => $this->title,
                'description' => $this->description,
                'started_at' => $this->started_at,
                'ended_at' => $this->ended_at,
                'project_id' => $this->project_id ?? null,
                'color_id' => $this->color_id ?? Color::DEFAULT,
            ]);
        }
        Flux::modal('edit-track')->close();
        $this->resetExcept(['selectedDate', 'colors']);
        $this->render();
    }

    public function deleteTrack($trackId)
    {
        \App\Models\Track::destroy($trackId);
        $this->resetExcept(['selectedDate', 'colors']);
        $this->render();
    }

    public function render()
    {
        $tracks = \App\Models\Track::with('color')->where('user_id', auth()->id())
            ->whereDate('started_at', $this->selectedDate)->get()->sortBy('started_at');

        return view('livewire.track', compact('tracks'));
    }
}
