<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{

    use HasFactory;
    const DEFAULT = 1;
    const GRAY = 1;
    const RED = 2;
    const ORANGE = 3;
    const AMBER = 4;
    const YELLOW = 5;
    const LIME = 6;
    const GREEN = 7;
    const EMERALD = 8;
    const TEAL = 9;
    const CYAN = 10;
    const SKY = 11;
    const BLUE = 12;
    const INDIGO = 13;
    const VIOLET = 14;
    const PURPLE = 15;
    const FUCHSIA = 16;
    const PINK = 17;
    const ROSE = 18;

    protected $fillable = [
        'name',
        'light_color',
        'dark_color',
        'text_light_color',
        'text_dark_color',
    ];

    protected $casts = [
        'light_color' => 'string',
        'dark_color' => 'string',
        'text_light_color' => 'string',
        'text_dark_color' => 'string',
    ];
}
