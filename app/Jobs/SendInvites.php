<?php

namespace App\Jobs;

use App\Mail\InviteEmail;
use App\Models\Organization;
use App\Models\OrganizationInvites;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendInvites implements ShouldQueue
{
    use Queueable;

    public $inviteesList;
    public User $user;
    public Organization $organization;

    /**
     * Create a new job instance.
     */
    public function __construct($inviteesList, User $user, Organization $organization)
    {
        $this->inviteesList = $inviteesList;
        $this->user = $user;
        $this->organization = $organization;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Logic to send invites
        foreach ($this->inviteesList as $invitee) {
            $token = md5($invitee . time());

            // Check if the invitee already exists in the organization
            $existingUser = OrganizationInvites::where('email', $invitee)->where('status', 'like', 'pending')->where('created_at', '>=', now()->subDay(7))->first();
            if ($existingUser) {
                // If the invitee already exists, skip sending the invite
                continue;
            }

            OrganizationInvites::create([
                'organization_id' => $this->organization->id,
                'invited_by' => $this->user->id,
                'email' => $invitee,
                'token' => $token,
            ]);

            Mail::to($invitee)->send(new InviteEmail($token, $this->user, $this->organization));
        }

    }
}
