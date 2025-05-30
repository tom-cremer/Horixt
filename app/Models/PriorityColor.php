<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityColor extends Model
{
    protected $fillable = [
        'priority_id',
        'color_id',
        'user_id',
        'organization_id',
    ];

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
