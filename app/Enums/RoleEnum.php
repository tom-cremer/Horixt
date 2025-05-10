<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case REVIEWER = 'reviewer';
    case INTERN = 'intern';
    case GUEST = 'guest';


    // Role Colors
    public function color(): string
    {
        return match ($this) {
            self::ADMIN => 'amber',
            self::MEMBER => 'blue',
            self::REVIEWER => 'teal',
            self::INTERN => 'purple',
            self::GUEST => 'zinc',
        };
    }


    public static function values(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
