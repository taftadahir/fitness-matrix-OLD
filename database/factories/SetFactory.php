<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Set;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class SetFactory extends Factory
{
    protected $model = Set::class;

    public function definition()
    {
        $prevable_type = $this->faker->randomElement(['program']);
        return [
            'prevable_type' => $prevable_type,
            'prevable_id' => $this->faker->randomElement(DB::table($prevable_type . 's')->pluck('id')),
            'program_id' => $this->faker->randomElement(Program::select('id')->get()),
            'name' => $this->faker->name(),
            'day' => $this->faker->numberBetween(0, 100),
            'set' => $this->faker->numberBetween(0, 100),
            'rest_time' => $this->faker->numberBetween(0, 10000000),
            'warm_up_set' => $this->faker->boolean,
        ];
    }

    public function warm_up_set()
    {
        return $this->state(function (array $attributes) {
            return [
                'warm_up_set' => true,
            ];
        });
    }

    public function program($program)
    {
        return $this->state(function (array $attributes) use ($program) {
            return [
                'program_id' => $program->id,
            ];
        });
    }
}
