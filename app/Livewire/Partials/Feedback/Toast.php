<?php

namespace App\Livewire\Partials\Feedback;

use App\Livewire\Component\HorixtComponent;
use Livewire\Attributes\On;

class Toast extends HorixtComponent
{

    /*
        How to dispatch a toast!

        $this->dispatch('toast', [
             'title' => 'Title you want',
             'message' => 'Text you want',
             'type' => 'Status you want',
             'duration' => duration you want default 5000ms,
         ]);

    (cause I might forget^^)
    */


    public $title = '';
    public $message = '';

    public $type = '';
    public $visible = false;
    public $duration = 5000;
    #[On('toast')]
    public function showToast($data)
    {
        $this->title = $data['title'] ?? '';
        $this->message = $data['message'] ?? '';
        $this->type = $data['type'] ?? 'info';
        $this->visible = true;
        $this->duration = $data['duration'] ?? 5000;

        // Start auto-hide timer
        $this->dispatch('start-toast-timer');
    }

    public function hide()
    {
        $this->visible = false;
    }

    public function render()
    {
        return view('livewire.partials.feedback.toast');
    }
}

