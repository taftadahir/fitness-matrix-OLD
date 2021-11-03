<?php

namespace Tests\Feature\Exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateExerciseWithValidDataTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $exercise = Exercise::factory()->create();
        // dd($exercise->id);

        $this->actingAs($user)->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            $exercise->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'message', 'exercise' => ['name', 'time_based', 'reps_based', 'published', 'image']
            ]);
    }

    /**
     * @test
     */
    public function updateExerciseWithValidDataTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $exercise = Exercise::factory()->user($user)->create();

        $this->actingAs($user2)->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            $exercise->getAttributes()
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function updateExerciseWithInvalidIdValidDataToken()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $exercise = Exercise::factory()->user($user)->create();

        $this->actingAs($user2)->putJson(
            route('exercise.update', ['exercise' => 22]),
            $exercise->getAttributes()
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function updateExerciseWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $exercise = Exercise::factory()->user($user)->create();

        $this->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            $exercise->getAttributes()
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
