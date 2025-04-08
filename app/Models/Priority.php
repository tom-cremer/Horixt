<?php

namespace App\Models;

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


}
