<?php

namespace Database\Seeders;

use App\Models\GymUser;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class GymUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GymUser::create([
			'gym_id'		=>  1,
			'user_id'		=>  1,
		]);

        GymUser::create([
			'gym_id'		=>  2,
			'user_id'		=>  2,
		]);



    }
}
