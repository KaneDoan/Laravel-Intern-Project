<?php

namespace Database\Seeders;

use App\Models\Exercise;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exercise::create([
			'name'		=> 'push up',
		]);

        Exercise::create([
            'name'		=> 'plank',
		]);



    }
}
