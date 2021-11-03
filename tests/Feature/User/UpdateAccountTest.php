<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateAccountWithValidDataToken()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->putJson(route('user.update'), ['first_name' => 'Tafta'])->assertOk()->assertJsonStructure(['message', 'user' => [
            'first_name', 'last_name', 'email', 'gender', 'avatar', 'created_at', 'updated_at', 'deleted_at'
        ]]);
    }

    /**
     * @test
     */
    public function updateAccountWithInValidToken()
    {
        $user = User::factory()->admin()->create();

        $this->putJson(route('user.update'), ['first_name' => 'Tafta'])->assertUnauthorized()->assertJsonStructure(['message']);
    }
}
