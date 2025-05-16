<?php

namespace App\Livewire;

use App\Livewire\Component\HorixtComponent;
use App\Models\Organization;
use Flux\Flux;

class Organizations extends HorixtComponent
{

    public $organizations;

    public $name;
    public $slug;
    public $description;
    public $email;
    public $website;
    public $phone;

    public function toOrganization($id)
    {
        return redirect()->route('organization.dashboard', ['slug' => Organization::find($id)->slug]);
    }

    public function openAddOrganizationModal()
    {
        Flux::modal('add-organization')->show();
    }

    public function createOrganization()
    {
        $validatedAttribute = $this->validate([
            'name' => 'required|string|max:25',
            'slug' => 'required|string|max:13|unique:organizations|regex:/^[a-z0-9-]*$/',
            'description' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        Organization::create([
            'name' => $validatedAttribute['name'],
            'slug' => $validatedAttribute['slug'],
            'description' => $validatedAttribute['description'],
            'email' => $validatedAttribute['email'],
            'website' => $validatedAttribute['website'],
            'phone' => $validatedAttribute['phone'],
            'owner_id' => auth()->id(),
        ]);
        $this->resetExcept(['organizations']);
        Flux::modal('add-organization')->close();
    }

    public function render()
    {
        $this->organizations = auth()->user()->organizations;

        return view('livewire.organizations');
    }
}
