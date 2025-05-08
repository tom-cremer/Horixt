<?php

namespace App\Helper;

use App\Models\Directories;
use App\Models\Organization;
use App\Models\User;
use App\Traits\HasUuid;
use Illuminate\Support\Facades\Storage;

class FileManagerHelper
{

    // creates the directory structure for a user
    public static function createUserDirectory(User $user): void
    {
        $basePath = "personal/{$user->uuid}";
        Storage::makeDirectory("{$basePath}/projects");

        $root = Directories::create([
            'name' => 'root',
            'path' => $basePath,
            'disk' => 'local',
            'visibility' => null,
            'locked' => false,
            'protected' => true,
            'user_id' => $user->id,
            'organization_id' => null,
            'project_id' => null,
            'parent_id' => null,
        ]);

        Directories::create([
            'name' => 'projects',
            'path' => "{$basePath}/projects",
            'disk' => 'local',
            'visibility' => null,
            'locked' => false,
            'protected' => true,
            'user_id' => $user->id,
            'organization_id' => null,
            'project_id' => null,
            'parent_id' => $root->id,
        ]);
    }

    // creates the directory structure for an organization
    public static function createOrganizationDirectory(Organization $organization, User $user): void
    {
        $basePath = "organizations/{$organization->uuid}";
        Storage::makeDirectory("{$basePath}/projects");

        $root = Directories::create([
            'name' => 'root',
            'path' => $basePath,
            'disk' => 'local',
            'visibility' => null,
            'locked' => false,
            'protected' => true,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'project_id' => null,
            'parent_id' => null,
        ]);

        Directories::create([
            'name' => 'projects',
            'path' => "{$basePath}/projects",
            'disk' => 'local',
            'visibility' => null,
            'locked' => false,
            'protected' => true,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'project_id' => null,
            'parent_id' => $root->id,
        ]);

    }
}
