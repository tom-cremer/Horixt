<?php

namespace App\Livewire\Settings;

use App\Models\Color;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Status;
use Livewire\Component;

class Preferences extends Component
{
    public $statuses;
    public $priorities;
    public $colors;
    public $preferredOrganizationId;
    public $preferredOrganizationName;

    public function mount()
    {
        $this->preferredOrganizationId = auth()->user()->preferred_organization_id;
        $this->preferredOrganizationName = Organization::find($this->preferredOrganizationId)->name ?? null;
        $this->statuses = Status::all();
        $this->priorities = Priority::all();
        $this->colors = Color::all();
    }

    public function updatePreferredOrg($orgId)
    {

        $user = auth()->user();
        $user->preferred_organization_id = $orgId;
        $user->save();

        $this->preferredOrganizationId = $orgId;
        $this->preferredOrganizationName = Organization::find($this->preferredOrganizationId)->name ?? null;

        $this->dispatch('toast', [
            'title' => 'Preferred Organization Updated',
            'message' => 'Your preferred organization has been updated successfully.',
            'type' => 'success', // success, warning, error, info
            //'duration' => Default 5000ms,
        ]);

    }


    public function updateStatusColor($statusId, $colorId)
    {
        $status = Status::findOrFail($statusId);
        $status->userStatusColor->update([
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
        $priority->userPriorityColor->update([
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
        return view('livewire.settings.preferences');
    }
}
