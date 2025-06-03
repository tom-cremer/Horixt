<?php

namespace App\Models;

use App\Helper\Context;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'organization_id',
        'status_id',
        'priority_id',
        'color_id',
        'due_at',
    ];

    protected $casts = [
        'due_at' => 'date',
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'due_at' => $this->due_at ? $this->due_at->toDateString() : null,
        ];
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'project_id', 'id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function priority(): HasOne
    {
        return $this->hasOne(Priority::class, 'id', 'priority_id');
    }

    public function favorite(): HasOne
    {
        if (Context::isOrganization()) {
            return $this->hasOne(FavoriteProject::class, 'project_id', 'id')
                ->where('organization_id', Context::getOrganizationId());
        } else {
            return $this->hasOne(FavoriteProject::class, 'project_id', 'id')
                ->where('user_id', auth()->id())
                ->whereNull('organization_id');
        }
    }

}
