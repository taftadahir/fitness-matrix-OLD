<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::factory()
            ->admin()
            ->create();

        // Regular user
        User::factory(10)->create();
    }
}
