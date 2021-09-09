<?php

namespace Database\Seeders;

use App\Models\Gym;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gym::create([
			'name'		          => 'FitnessPlus',
			'pin'		          => '1234',
            'no_of_displays'      => '2',
		]);

        Gym::create([
			'name'		          => 'BodyBuilderEx',
			'pin'		          => '5678',
            'no_of_displays'      => '3',
		]);
    }
}
