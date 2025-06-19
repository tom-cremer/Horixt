<?php

namespace App\Livewire;

use App\Models\Badges;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Nfc extends Component
{

    public $token;
    public $badge;


    public $selectedBadge = false; // false by default == dark badge | true == light badge

    public function mount($token)
    {
        $this->token = $token;
        $this->badge = Badges::where('token', $this->token)->first();
    }

    public function downloadBadge()
    {
        Flux::modal('downloadBadgeModal')->show();
    }

    public function toggleBadge()
    {
        $this->selectedBadge = !$this->selectedBadge;
    }

    public function startDownloadBadge()
    {
        if (!$this->selectedBadge) {
            return Storage::disk('local')->download('badges/' . $this->badge->dark_badge_image);
        } else {
            return Storage::disk('local')->download('badges/' . $this->badge->light_badge_image);
        }

    }

    public function render()
    {
        return view('livewire.nfc')->layout('components.layouts.nfc-layout');
    }
}
