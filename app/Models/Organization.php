<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'website',
        'email',
        'phone',
/*        'logo',*/
        'owner_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getRouteKey()
    {
        return $this->slug;
    }



}
