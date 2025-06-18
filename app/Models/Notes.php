<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'color_id',
        'project_id',
        'title',
        'content'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

}
