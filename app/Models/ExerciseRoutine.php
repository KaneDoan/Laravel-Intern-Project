<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExerciseRoutine extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeSearch($query, $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->orWhere(function ($query) use ($search) {
            $query->where('sort_id', 'like', '%'.$search.'%');
        })->orWhere(function ($query) use ($search) {
            $query->where('display_id', 'like', '%'.$search.'%');
        })->orWhere(function ($query) use ($search) {
            $query->where('default_reps', 'like', '%'.$search.'%');
        });
    }

    public function scopeSearchByName($query, $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }

    public function scopeRoutineId($query, $routineId)
    {
        $exerciseIds = collect(ExerciseRoutine::whereRoutineId($routineId)->get())->pluck('exercise_id')->values();
        info($exerciseIds);
        return $query->whereIn('id', $exerciseIds);
    }

    public function scopeExerciseId($query, $exerciseId)
    {
        $routineIds = collect(ExerciseRoutine::whereExerciseId($exerciseId)->get())->pluck('routine_id')->values();
        info($routineIds);
        return $query->whereIn('id', $routineIds);
    }

}
