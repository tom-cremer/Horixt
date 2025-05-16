<?php

namespace App\Livewire;

use App\Enums\RoleEnum;
use App\Livewire\Component\HorixtComponent;
use App\Models\Organization;
use Flux\Flux;
use Livewire\Component;

class Header extends HorixtComponent
{

    public $owner_id;
    public $slug;

    public function mount()
    {
        $this->owner_id = auth()->user()->id;
    }

    public function render()
    {
        return view('livewire.header');
    }
}
