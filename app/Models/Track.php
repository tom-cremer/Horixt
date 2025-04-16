<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Track extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'started_at',
        'ended_at',
        'color_id',
        'user_id',
        'project_id',
        'organization_id'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];



    public function color(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

}
