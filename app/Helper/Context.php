<?php

namespace App\Helper;
use App\Models\Organization;

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

    public static function getOrganizationSlug(): ?string
    {
        return Organization::where('id', self::getOrganizationId())->first()->slug ?? null;
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

