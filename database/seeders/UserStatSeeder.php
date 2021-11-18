<?php

namespace Database\Seeders;

use App\Models\UserStat;
use Illuminate\Database\Seeder;

class UserStatSeeder extends Seeder
{
    public function run()
    {
        UserStat::factory(10)->create();
    }
}
