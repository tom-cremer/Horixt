<?php

namespace App\Jobs;

use App\Models\OrganizationInvites;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckInvitesValidity implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        OrganizationInvites::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(7))
            ->update(['status' => 'expired']);
    }
}
