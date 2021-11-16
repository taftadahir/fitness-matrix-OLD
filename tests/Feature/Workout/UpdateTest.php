<?php

namespace Tests\Feature\Workout;

use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateWorkoutWithValidDataTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $this->actingAs($user)->putJson(
            route('workout.update', ['workout' => $workout->id]),
            $workout->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'message', 'workout' => ['exercise_id', 'program_id', 'day', 'reps_based', 'reps', 'time_based', 'time', 'set', 'rest_time']
            ]);
    }

    /**
     * @test
     */
    public function updateWorkoutWithValidDataTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $this->actingAs($user2)->putJson(
            route('workout.update', ['workout' => $workout->id]),
            $workout->getAttributes()
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function updateWorkoutWithValidDataTokenIsProgramCreatorAndInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $this->actingAs($user)->putJson(
            route('workout.update', ['workout' => 9000000]),
            $workout->getAttributes()
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function updateWorkoutWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $this->putJson(
            route('workout.update', ['workout' => $workout->id]),
            $workout->getAttributes()
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
