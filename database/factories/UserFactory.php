<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'abc123@ABC123', // abc123@ABC123
            'password_confirmation' => 'abc123@ABC123', // abc123@ABC123
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function male()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => $this->faker->firstName('male'),
                'gender' => 'male',
            ];
        });
    }

    public function female()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => $this->faker->firstName('female'),
                'gender' => 'female',
            ];
        });
    }

    public function avatar($avatar = 'default')
    {
        return $this->state(function (array $attributes) use ($avatar) {
            return [
                'avatar' => $avatar,
            ];
        });
    }

    public function email($email)
    {
        return $this->state(function (array $attributes) use ($email) {
            return [
                'email' => $email,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => 'admin@admin.com',
                'first_name' => 'admin',
                'last_name' => 'admin'
            ];
        });
    }
}
