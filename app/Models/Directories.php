<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

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

    public function files()
    {
        return $this->hasMany(Files::class, 'directory_id');
    }

    public function parent()
    {
        return $this->belongsTo(Directories::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Directories::class, 'parent_id');
    }
}
