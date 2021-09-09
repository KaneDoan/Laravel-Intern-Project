<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'default_set',
        'timer',
        'rest_timer',
    ];

    public function exerciseRoutine()
    {
        return $this->hasMany(ExerciseRoutine::class);
    }

}
