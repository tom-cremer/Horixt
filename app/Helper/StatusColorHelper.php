<?php

namespace App\Helper;

use App\Models\Color;
use App\Models\Organization;
use App\Models\Status;
use App\Models\StatusColor;
use App\Models\User;

class StatusColorHelper
{
    public static function seedUserStatusColor(User $user): void
    {
        foreach (Status::all() as $status) {
            StatusColor::firstOrCreate([
                'status_id' => $status->id,
                'user_id' => $user->id,
                'organization_id' => null,
            ], [
                'color_id' => self::defaultColorForKey($status->id),
            ]);
        }
    }

    public static function seedOrganizationStatusColor(Organization $organization): void
    {
        foreach (Status::all() as $status) {
            StatusColor::firstOrCreate([
                'status_id' => $status->id,
                'organization_id' => $organization->id,
                'user_id' => null,
            ], [
                'color_id' => self::defaultColorForKey($status->id),
            ]);
        }
    }

    protected static function defaultColorForKey($key): string
    {
        return match ($key) {
            Status::STUCK => Color::RED,
            Status::IN_PROGRESS => Color::BLUE,
            Status::COMPLETED => Color::EMERALD,
            default => Color::GRAY,
        };
    }
}
