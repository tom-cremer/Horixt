<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{

    protected $fillable = [
        'path',
        'name',
        'extension',
        'mime_type',
        'size',
        'disk',
        'user_id',
        'organization_id',
    ];

    /**
     * Get the user that owns the avatar.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organization that owns the avatar, if applicable.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}
