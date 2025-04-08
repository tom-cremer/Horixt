<?php

namespace App\Models;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status_id',
        'priority_id',
        'color_id',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'project_id', 'id');
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
