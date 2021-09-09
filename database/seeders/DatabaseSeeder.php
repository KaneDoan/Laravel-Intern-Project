<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\ExerciseRoutineSeeder;
use Database\Seeders\ExerciseSeeder;
use Database\Seeders\RoutineSeeder;
use Database\Seeders\GymSeeder;
use Database\Seeders\GymUserSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(GymSeeder::class);
        $this->call(GymUserSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(RoutineSeeder::class);
        $this->call(ExerciseRoutineSeeder::class);
    }
}
