<?php

namespace App\Models;

use App\Enums\NotificationType;
use App\Helper\TimezoneHelper;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'app_notifications';

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'type' => NotificationType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        TimezoneHelper::set();
        $this->update(['read_at' => now()]);
    }

    public function markAsUnread()
    {
        TimezoneHelper::set();
        $this->update(['read_at' => null]);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
