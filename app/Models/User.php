<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Observers\UserObserver;
use App\Traits\HasUuid;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasUuid, HasRoles, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'user_id');
    }

    public function assignedTodos(): BelongsToMany
    {
        return $this->belongsToMany(Todo::class, 'assigned_todo')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function favoriteProjects()
    {
        return $this->hasMany(FavoriteProject::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_user')
            ->withPivot('user_id', 'organization_id', 'is_active')
            ->wherePivot('is_active', true)
            ->withTimestamps();
    }

    // Organizations owned by the user
    public function ownedOrganizations()
    {
        return $this->hasMany(Organization::class, 'owner_id');
    }

    // Check if the user is the owner of an organization
    public function isOwner($organizationId): bool
    {
        $organization = Organization::find($organizationId);
        if (!$organization) {
            return false;
        }
        return $this->id === $organization->owner_id;
    }

    /*-------------File manager RELATIONSHIPS--------------*/
    public function directories()
    {
        return $this->hasMany(Directories::class);
    }

    public function files()
    {
        return $this->hasMany(Files::class);
    }

    /*-------------Avatar--------------*/
    public function avatar(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    /*-------------Super Admin--------------*/
    public function administrator(): HasOne
    {
        return $this->hasOne(Administrators::class);
    }

    /*-------------COMMENTS RELATIONSHIPS--------------*/

    public function comments(): HasMany
    {
        return $this->hasMany(TodoComment::class, 'user_id');
    }

}
