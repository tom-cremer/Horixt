<?php

namespace App\Livewire\Settings;

use App\Helper\Context;
use App\Livewire\Component\HorixtComponent;
use App\Models\Avatar;
use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class OrgSettings extends HorixtComponent
{
    use WithFileUploads;

    public $organization;


    public $avatar;
    public $name;
    public $slug;


    public $statuses;
    public $priorities;
    public $colors;

    public function mount(): void
    {
        $this->organization = Context::getOrganization();
        $this->statuses = Status::all();
        $this->priorities = Priority::all();
        $this->colors = Color::all();
    }

    public function update()
    {
        $user = Auth::user();
        $baseValidation = [
            'name' => 'required|string|max:25',
            'slug' => [
                'required',
                'string',
                'max:13',
                'regex:/^[a-z0-9-]*$/',
                Rule::unique('organizations')->ignore($this->organization->id)
            ],
        ];

        if ($this->avatar) {
            $baseValidation['avatar'] = ['image', 'max:2048'];
        }

        $validatedAttribute = $this->validate($baseValidation);

        $this->organization->update([
            'name' => $validatedAttribute['name'],
            'slug' => $validatedAttribute['slug'],
        ]);


        if ($this->avatar) {

            $path = $this->avatar->storePubliclyAs('avatars',$this->organization->uuid . '.' . $this->avatar->getClientOriginalExtension(), ['disk' => 'public']);

            Avatar::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'organization_id' => $this->organization->id,
                    'path' => $path,
                ],
                [
                    'path' => $path,
                    'mime_type' => $this->avatar->getMimeType(),
                    'size' => $this->avatar->getSize(),
                    'name' => $this->avatar->getClientOriginalName(),
                    'extension' => $this->avatar->getClientOriginalExtension(),
                    'disk' => 'public',
                    'user_id' => $user->id,
                    'organization_id' => $this->organization->id,
                ]
            );
        }

        return redirect()->route('organization.settings.org-settings', ['slug' => $this->organization->slug]);
    }


    public function updateStatusColor($statusId, $colorId)
    {
        $status = Status::findOrFail($statusId);
        $status->organizationStatusColor->update([
            'color_id' => $colorId,
        ]);

        $this->statuses = Status::all(); // Refresh

        $this->dispatch('toast', [
            'title' => 'Status Color Updated',
            'message' => 'Status color has been updated successfully.',
            'type' => 'success', // success, warning, error, info
            //'duration' => Default 5000ms,
        ]);
    }

    public function updatePriorityColor($priorityId, $colorId)
    {
        $priority = Priority::findOrFail($priorityId);
        $priority->organizationPriorityColor->update([
            'color_id' => $colorId,
        ]);

        $this->priorities = Priority::all(); // Refresh

        $this->dispatch('toast', [
            'title' => 'Priority Color Updated',
            'message' => 'Priority color has been updated successfully.',
            'type' => 'success', // success, warning, error, info
            //'duration' => Default 5000ms,
        ]);
    }

    public function render()
    {
        $this->name = $this->organization->name;
        $this->slug = $this->organization->slug;

        return view('livewire.settings.org-settings');
    }
}
