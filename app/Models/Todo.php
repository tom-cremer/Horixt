<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_done',
        'status_id',
        'priority_id',
        'color_id',
        'user_id',
        'project_id',
        'organization_id',
        'parent_id',
    ];

    public function project() :HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    public function status() :HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function priority() :HasOne
    {
        return $this->hasOne(Priority::class, 'id', 'priority_id');
    }
    public function tracks() :HasMany
    {
        return $this->hasMany(Track::class, 'todo_id', 'id');
    }

    public function children() :HasMany
    {
        return $this->hasMany(Todo::class, 'parent_id');
    }

    public function parent() :BelongsTo
    {
        return $this->belongsTo(Todo::class, 'parent_id');
    }

    public function files():MorphToMany
    {
        return $this->morphToMany(Files::class, 'fileable');
    }

}
