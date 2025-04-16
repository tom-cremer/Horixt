<?php

namespace App\Models;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
