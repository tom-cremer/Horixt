<?php

namespace App\Models;

use App\Helper\Context;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use hasFactory;

    const DEFAULT = 1;
    const NOT_STARTED = 1;
    const IN_PROGRESS = 2;
    const STUCK = 3;
    const COMPLETED = 4;

    protected $fillable = [
        'name',
    ];

    public function statusColors()
    {
        return $this->hasMany(StatusColor::class);
    }

    public function userStatusColor()
    {
        return $this->hasOne(StatusColor::class)
            ->where('user_id', auth()->id())
            ->whereNull('organization_id');
    }

    public function organizationStatusColor()
    {
        return $this->hasOne(StatusColor::class)
            ->where('organization_id', Context::getOrganizationId())
            ->whereNull('user_id');
    }


}
