<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Badges extends Model
{
    protected $fillable = [
        'code',
        'name',
        'token',
        'light_badge_image',
        'dark_badge_image',
    ];

}
