<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusColor extends Model
{
    protected $fillable = [
        'status_id',
        'color_id',
        'user_id',
        'organization_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
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
