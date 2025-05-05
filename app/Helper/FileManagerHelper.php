<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class FileManagerHelper
{

    public static function createUserDirectory(string $uuid): void
    {
        $basePath = "personal/{$uuid}";
        Storage::makeDirectory("{$basePath}/projects");
    }

    public static function createOrganizationDirectory(string $uuid): void
    {
        $basePath = "organizations/{$uuid}";
        Storage::makeDirectory("{$basePath}/projects");
    }
}
