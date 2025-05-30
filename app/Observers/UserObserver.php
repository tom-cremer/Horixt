<?php

namespace App\Observers;

use App\Helper\FileManagerHelper;
use App\Helper\PriorityColorHelper;
use App\Helper\StatusColorHelper;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        FileManagerHelper::createUserDirectory($user);
        PriorityColorHelper::seedUserPriorityColor($user);
        StatusColorHelper::seedUserStatusColor($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
