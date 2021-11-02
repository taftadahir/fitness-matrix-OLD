<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition()
    {
        return [
            'name' => $this->faker->realText(10),
            'time_based' => $this->faker->boolean,
            'reps_based' => $this->faker->boolean,
            'published' => false,
            'image' => $this->faker->slug,
            'user_id' => $this->faker->randomElement(User::select('id')->get())
        ];
    }

    public function time_based()
    {
        return $this->state(function (array $attributes) {
            return [
                'time_based' => true,
            ];
        });
    }

    public function reps_based()
    {
        return $this->state(function (array $attributes) {
            return [
                'reps_based' => true,
            ];
        });
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published' => true,
            ];
        });
    }

    public function name($name)
    {
        return $this->state(function (array $attributes) use ($name) {
            return [
                'name' => $name,
            ];
        });
    }

    public function user($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
