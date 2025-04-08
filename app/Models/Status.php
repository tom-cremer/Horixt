<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use hasFactory;
    const DEFAULT = 1;
    const NOT_STARTED = 1;
    const IN_PROGRESS = 2;
    const IN_REVIEW = 3;
    const COMPLETED = 4;
    protected $fillable = [
        'name',
    ];

}
