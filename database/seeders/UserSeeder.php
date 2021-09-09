<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
			'full_name'		=> 'John Doe',
			'is_admin'		=> true,
            'email'         => "admin@gmail.com",
            'password'      => Hash::make('password'),
		]);

        User::create([
			'full_name'		=> 'Alice Ann',
			'is_admin'		=> false,
            'email'         => "user1@gmail.com",
            'password'      => Hash::make('password'),
		]);



    }
}
