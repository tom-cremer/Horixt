<?php

namespace App\Observers;

use App\Enums\RoleEnum;
use App\Helper\FileManagerHelper;
use App\Models\Organization;

class OrganizationObserver
{
    /**
     * Handle the Organization "created" event.
     */
    public function created(Organization $organization): void
    {
        auth()->user()->organizations()->attach($organization->id);
        session(['team_id' => $organization->id]);
        setPermissionsTeamId(session('team_id'));
        auth()->user()->assignRole(RoleEnum::ADMIN->value);

        FileManagerHelper::createOrganizationDirectory($organization, auth()->user());
    }

    /**
     * Handle the Organization "updated" event.
     */
    public function updated($organization): void
    {
        //
    }

    /**
     * Handle the Organization "deleted" event.
     */
    public function deleted($organization): void
    {
        //
    }

    /**
     * Handle the Organization "restored" event.
     */
    public function restored($organization): void
    {
        //
    }

    /**
     * Handle the Organization "force deleted" event.
     */
    public function forceDeleted($organization): void
    {
        //
    }
}
