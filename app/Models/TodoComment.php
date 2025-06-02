<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoComment extends Model
{
    protected $fillable = [
        'todo_id',
        'user_id',
        'comment',
        'parent_id',
        'is_private',
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function parent()
    {
        return $this->belongsTo(TodoComment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TodoComment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
