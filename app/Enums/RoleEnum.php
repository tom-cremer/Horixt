<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case REVIEWER = 'reviewer';
    case INTERN = 'intern';
    case GUEST = 'guest';




    public static function values(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
