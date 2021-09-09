<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'routine_id',
        'sort_id',
        'display_id',
        'default_reps',
    ];

    public function exercise(){
        return $this->belongsTo(Exercise::class,'exercise_id');
    }

    public function routine(){
        return $this->belongsTo(Routine::class,'routine_id');
    }

}
