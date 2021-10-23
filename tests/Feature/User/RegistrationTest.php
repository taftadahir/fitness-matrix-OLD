<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userRegistrationWithValidDatas()
    {
        $user = User::factory()->admin()->make();
        $this->postJson(route('user.register'), $user->getAttributes())
            ->assertStatus(201)
            ->assertJsonStructure([
                'token', 'message', 'user' => [
                    'first_name', 'last_name', 'email', 'gender', 'avatar', 'created_at', 'updated_at', 'deleted_at'
                ]
            ]);
    }

    /**
     * @test
     */
    public function userRegistrationWithInValidEmailAddress()
    {
        $user = User::factory()->email('Invalid Email Address')->make();
        $this->postJson(route('user.register'), $user->getAttributes())
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors' => [
                    'email'
                ]
            ]);
    }
}
