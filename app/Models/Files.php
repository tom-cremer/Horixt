<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Files extends Model
{
    protected $fillable = [
        'name',
        'alt',
        'path',
        'size',
        'extension',
        'disk',
        'mime_type',
        'visibility',
        'checksum',
        'user_id',
        'organization_id',
        'project_id',
        'directory_id',
    ];

    public function directory()
    {
        return $this->belongsTo(Directories::class, 'directory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function todos(): MorphToMany
    {
        return $this->morphedByMany(Todo::class, 'fileable');
    }
}
