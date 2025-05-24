<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Directories extends Model
{
    use HasUuid;
    protected $fillable = [
        'name',
        'path',
        'disk',
        'visibility',
        'locked',
        'protected',
        'user_id',
        'organization_id',
        'project_id',
        'parent_id'
    ];

    public function files(): HasMany
    {
        return $this->hasMany(Files::class, 'directory_id');
    }

    public function parent() :BelongsTo
    {
        return $this->belongsTo(Directories::class, 'parent_id');
    }

    public function children() :HasMany
    {
        return $this->hasMany(Directories::class, 'parent_id');
    }
}
