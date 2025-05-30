<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProject extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'organization_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
