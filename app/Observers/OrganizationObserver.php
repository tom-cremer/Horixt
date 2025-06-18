<?php

namespace App\Observers;

use App\Enums\RoleEnum;
use App\Helper\FileManagerHelper;
use App\Helper\PriorityColorHelper;
use App\Helper\StatusColorHelper;
use App\Models\Organization;

class OrganizationObserver
{
    /**
     * Handle the Organization "created" event.
     */
    public function created(Organization $organization): void
    {
        StatusColorHelper::seedOrganizationStatusColor($organization);
        PriorityColorHelper::seedOrganizationPriorityColor($organization);

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
