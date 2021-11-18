<?php

namespace Database\Seeders;

use App\Models\Set;
use Illuminate\Database\Seeder;

class SetSeeder extends Seeder
{
    public function run()
    {
        Set::factory(10)->create();
    }
}
