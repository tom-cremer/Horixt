<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_done',
        'is_trackable',
        'status_id',
        'priority_id',
        'color_id',
        'user_id',
        'project_id',
        'organization_id',
        'parent_id',
    ];

    /*-------------PROJECT RELATIONSHIPS--------------*/
    public function project() :HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /*-------------STATUS RELATIONSHIPS--------------*/
    /*-------------PRIORITY RELATIONSHIPS--------------*/
    public function status() :HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function priority() :HasOne
    {
        return $this->hasOne(Priority::class, 'id', 'priority_id');
    }

    /*-------------TRACKS RELATIONSHIPS--------------*/
    public function tracks() :HasMany
    {
        return $this->hasMany(Track::class, 'todo_id', 'id');
    }

    /*-------------TODOS RELATIONSHIPS--------------*/
    public function children() :HasMany
    {
        return $this->hasMany(Todo::class, 'parent_id');
    }

    public function parent() :BelongsTo
    {
        return $this->belongsTo(Todo::class, 'parent_id');
    }
    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'assigned_todo')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    /*-------------FILES RELATIONSHIPS--------------*/
    public function files():MorphToMany
    {
        return $this->morphToMany(Files::class, 'fileable');
    }

    /*-------------COMMENTS RELATIONSHIPS--------------*/
    public function comments(): HasMany
    {
        return $this->hasMany(TodoComment::class, 'todo_id')
            ->whereNull('parent_id');
    }



}
