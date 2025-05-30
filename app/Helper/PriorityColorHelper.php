<?php

namespace App\Helper;

use App\Models\Color;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\PriorityColor;
use App\Models\User;

class PriorityColorHelper
{

    public static function seedUserPriorityColor(User $user)
    {
        foreach (Priority::all() as $priority)
        {
            PriorityColor::firstOrCreate([
                'priority_id' => $priority->id,
                'user_id' => $user->id,
                'organization_id' => null,
            ], [
                'color_id' =>self::defaultColorForKey($priority->id),
            ]);
        }

    }

    public static function seedOrganizationPriorityColor(Organization $organization)
    {
        foreach (Priority::all() as $priority)
        {
            PriorityColor::firstOrCreate([
                'priority_id' => $priority->id,
                'organization_id' => $organization->id,
                'user_id' => null,
            ], [
                'color_id' => self::defaultColorForKey($priority->id),
            ]);
        }
    }

    protected static function defaultColorForKey($key): string
    {
        return match ($key) {
            Priority::LOW => Color::BLUE,
            Priority::MEDIUM => Color::YELLOW,
            Priority::HIGH => Color::RED,
            Priority::URGENT => Color::VIOLET,
            default => Color::GRAY,
        };
    }
}
