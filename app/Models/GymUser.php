<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gym_id',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function gym(){
        return $this->belongsTo(Gym::class,'gym_id');
    }
}
