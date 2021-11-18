<?php

namespace Database\Seeders;

use Database\Factories\WorkoutFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ExerciseSeeder::class,
            ProgramSeeder::class,
            SetSeeder::class,
            WorkoutSeeder::class,
            UserStatSeeder::class,
        ]);
    }
}
