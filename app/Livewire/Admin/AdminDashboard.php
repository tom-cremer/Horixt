<?php

namespace App\Livewire\Admin;

use App\Models\Badges;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminDashboard extends Component
{

    use WithFileUploads;

    public $usersCount;
    public $organizationsCount;

    public $badges;


    public $code = '#00';
    public $lightImage;
    public $darkImage;
    public $editingBadgeId = null;

    public function mount()
    {
        $this->usersCount = User::count();
        $this->organizationsCount = Organization::count();
    }

    public function getUserCreatedThisMonth()
    {
        return User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getOrganizationCreatedThisMonth()
    {
        return Organization::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }


    public function save()
    {
        $this->validate([
            'code' => 'required|unique:badges,code,' . $this->editingBadgeId,
            'lightImage' => $this->editingBadgeId ? 'nullable|image' : 'required|image',
            'darkImage' => $this->editingBadgeId ? 'nullable|image' : 'required|image',
        ]);

        $badge = $this->editingBadgeId ? Badges::find($this->editingBadgeId) : new Badges();
        $badge->code = $this->code;
        do {
            $token = Str::random(40);
        } while (Badges::where('token', $token)->exists());

        $badge->token = $token;

        if($this->lightImage){
        $badge->name = $this->lightImage->getClientOriginalName();
        $lightPath = $this->lightImage->storeAs('badges', $this->lightImage->getClientOriginalName());
        $badge->light_badge_image = basename($lightPath);
    }

        if ($this->darkImage) {
            $darkPath = $this->darkImage->storeAs('badges', $this->darkImage->getClientOriginalName());
            $badge->dark_badge_image = basename($darkPath);
        }

        $badge->save();

        $this->reset(['code', 'lightImage', 'darkImage', 'editingBadgeId']);
        $this->dispatch('toast', [
            'title' => 'Badge Saved',
            'message' => 'Badge has been successfully saved.',
            'type' => 'success', // success, warning, error, info
            //'duration' => Default 5000ms,
        ]);
    }

    public function editBadge($id)
    {
        $badge = Badges::findOrFail($id);
        $this->editingBadgeId = $badge->id;
        $this->code = $badge->code;
    }

    public function deleteBadge($id)
    {
        $badge = Badges::findOrFail($id);
        Storage::disk('private')->delete([
            'badges/' . $badge->light_variant_path,
            'badges/' . $badge->dark_variant_path,
        ]);
        $badge->delete();
    }


    public function render()
    {
        $this->badges = Badges::all();
        return view('livewire.admin.admin-dashboard')->layout('components.layouts.super-admin-layout');
    }
}
