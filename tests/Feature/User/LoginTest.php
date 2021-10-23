<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function loginWithValidCredential()
    {
        $user = User::factory()->hash()->create();

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => 'abc123@ABC123'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'token', 'message', 'user' => [
                'first_name', 'last_name', 'email', 'gender', 'avatar', 'created_at', 'updated_at', 'deleted_at'
            ]
        ]);
    }

    /**
     * @test
     */
    public function loginWithInValidEmailAddress()
    {
        $user = User::factory()->make();
        $this->postJson(route('user.login'), [
            'email' => 'Invalid Email Address',
            'password' => 'abc123@ABC123'
        ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors' => [
                    'email'
                ]
            ]);
    }

    /**
     * @test
     */
    public function loginWithTooMuchttempts()
    {
        $user = User::factory()->make();
        for ($i = 0; $i < 4; $i++) {
            $response = $this->postJson(route('user.login'), [
                'email' => $user->email,
                'password' => 'abc123@AB123'
            ]);
        }
        $response->assertStatus(422)->assertJsonStructure([
            'message', 'errors' => ['credential']
        ]);
    }
}
