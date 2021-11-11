<?php

namespace Tests\Feature\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteProgramWithValidTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->user($user)->create();

        $this->actingAs($user)->deleteJson(
            route('program.destroy', ['program' => $record->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteProgramWithValidTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $record = Program::factory()->user($user)->create();

        $this->actingAs($user2)->deleteJson(
            route('program.destroy', ['program' => $record->id])
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteProgramWithValidTokenIsCreatorInvalidId()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->deleteJson(
            route('program.destroy', ['program' => 22])
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteProgramWithInValidToken()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->user($user)->create();

        $this->deleteJson(
            route('program.destroy', ['program' => $record->id])
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
