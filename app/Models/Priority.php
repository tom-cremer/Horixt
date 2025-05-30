<?php

namespace App\Models;

use App\Helper\Context;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use hasFactory;

    const DEFAULT = 1;
    const LOW = 1;
    const MEDIUM = 2;
    const HIGH = 3;
    const URGENT = 4;

    protected $fillable = [
        'name',
    ];

    public function priorityColors()
    {
        return $this->hasMany(PriorityColor::class);
    }

    public function userPriorityColor()
    {
        return $this->hasOne(PriorityColor::class)
            ->where('user_id', auth()->id())
            ->whereNull('organization_id');
    }

    public function organizationPriorityColor()
    {
        return $this->hasOne(PriorityColor::class)
            ->where('organization_id', Context::getOrganizationId())
            ->whereNull('user_id');
    }

}
