<?php

namespace App\Models;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
        'start_date',
        'end_date',
        'priority',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
        'priority' => ProjectPriority::class,
    ];

}
