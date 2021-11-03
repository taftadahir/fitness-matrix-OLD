<?php

namespace Tests\Feature\Exercise;

use App\Models\Exercise;
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
    public function deleteExerciseWithValidTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $exercise = Exercise::factory()->user($user)->create();

        $this->actingAs($user)->deleteJson(
            route('exercise.destroy', ['exercise' => $exercise->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteExerciseWithValidTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $exercise = Exercise::factory()->user($user)->create();

        $this->actingAs($user2)->deleteJson(
            route('exercise.destroy', ['exercise' => $exercise->id])
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteExerciseWithValidTokenIsCreatorInvalidId()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->deleteJson(
            route('exercise.destroy', ['exercise' => 22])
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteExerciseWithInValidToken()
    {
        $user = User::factory()->admin()->create();
        $exercise = Exercise::factory()->user($user)->create();

        $this->deleteJson(
            route('exercise.destroy', ['exercise' => $exercise->id])
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
