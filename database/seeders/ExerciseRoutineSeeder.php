<?php

namespace Database\Seeders;

use App\Models\ExerciseRoutine;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ExerciseRoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExerciseRoutine::create([
            'exercise_id'       => 1,
            'routine_id'        => 1,
			'sort_id'		    => 1,
			'display_id'		=> 1,
            'default_reps'      => 1,
		]);

        ExerciseRoutine::create([
            'exercise_id'       => 2,
            'routine_id'        => 2,
			'sort_id'		    => 2,
			'display_id'		=> 2,
            'default_reps'      => 2,
		]);



    }
}
