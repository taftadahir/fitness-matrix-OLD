<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteAccountWhileProvidingValidToken()
    {
        $user = User::factory()->withConfirmation()->admin()->make();
        $response = $this->postJson(route('user.register'), $user->getAttributes());
        $this->deleteJson(route('user.delete'), [], [
            'Authorization' => 'Bearer ' . $response['token']
        ])
            ->assertOk()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function deleteAccountWhileProvidingInValidToken()
    {
        $this->deleteJson(route('user.delete'), [], [
            'Authorization' => 'Bearer ' . "Invalid token"
        ])
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
