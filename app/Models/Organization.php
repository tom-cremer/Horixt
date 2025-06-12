<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\OrganizationObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[ObservedBy(OrganizationObserver::class)]
class Organization extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'owner_id',
    ];

    public function activeMembers()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_active', 'joined_at', 'last_active'])
            ->wherePivot('is_active', true)
            ->with(['roles'])
            ->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_active', 'joined_at', 'last_active'])
            ->wherePivot('is_active', true)
            ->with(['roles'])
            ->withTimestamps();
    }


    public function allMembers()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_active', 'joined_at', 'last_active'])
            ->with(['roles'])
            ->withTimestamps();
    }

    public function inactiveMembers()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['is_active', 'joined_at', 'last_active'])
            ->wherePivot('is_active', true)
            ->with(['roles'])
            ->withTimestamps();
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

// File manager

    public function directories()
    {
        return $this->hasMany(Directories::class);
    }

    public function files()
    {
        return $this->hasMany(Files::class);
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /*-------------NOTES--------------*/

    public function notes()
    {
        return $this->hasMany(Notes::class)->where('organization_id', $this->id);
    }
}
