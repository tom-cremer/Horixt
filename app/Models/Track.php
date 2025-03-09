<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'started_at',
        'ended_at',
        'description',
        'user_id'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
