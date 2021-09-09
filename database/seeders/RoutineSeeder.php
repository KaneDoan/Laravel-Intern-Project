<?php

namespace Database\Seeders;

use App\Models\Routine;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class RoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Routine::create([
			'name'		    => 'Warm Up',
			'default_set'	=> 0,
            'timer'         => 60,
            'rest_timer'    => 60,
		]);

        Routine::create([
			'name'		    => 'Step Strong',
			'default_set'	=> 0,
            'timer'         => 15,
            'rest_timer'    => 30,
		]);



    }
}
