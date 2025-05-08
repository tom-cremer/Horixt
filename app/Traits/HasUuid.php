<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            do {
                $uuid = Str::uuid()->toString();
            } while (
                $model->newQuery()->where('uuid', $uuid)->exists()
            );

            $model->uuid = $uuid;
        });
    }
}
