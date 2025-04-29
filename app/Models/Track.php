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
        'started_at',
        'ended_at',
        'user_id',
        'todo_id',
        'durations'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];


    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function todo() :BelongsTo
    {
        return $this->belongsTo(Todo::class, 'todo_id', 'id');
    }
}
