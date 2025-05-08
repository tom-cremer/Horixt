<?php

namespace App\Livewire;

use App\Enums\RoleEnum;
use App\Models\Organization;
use Flux\Flux;
use Livewire\Component;

class Header extends Component
{
    public $name;
    public $description;
    public $website;
    public $email;
    public $phone;
    public $logo;
    public $owner_id;
    public $slug;

    public function mount()
    {
        $this->owner_id = auth()->user()->id;
    }

    public function createOrganization()
    {
        $this->slug = str($this->name)->slug();

        Organization::create([
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'owner_id' => $this->owner_id,
            'slug' => $this->slug,
        ]);

        Flux::modal('create-organization')->close();

        $this->dispatch('organization-created');
    }

    public function render()
    {
        return view('livewire.header');
    }
}
