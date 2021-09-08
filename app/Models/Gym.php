<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'pin',
        'no_of_displays',
    ];

    public function gymUser()
    {
        return $this->hasMany(GymUser::class);
    }
}
