<?php

namespace App\Helper;
class Context
{
    public static function isOrganization(): bool
    {
        return session()->has('organization_id');
    }

    public static function getOrganizationId(): ?int
    {
        return session('organization_id');
    }

    public static function isPersonal(): bool
    {
        return !self::isOrganization();
    }

    public static function reset(): void
    {
        session()->forget('organization_id');
    }
}

