<?php

namespace Tests\Feature\Workout;

use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeWorkoutWithValidDatasAndIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();

        $record = Workout::factory()->program($program)->make();
        $this->actingAs($user)->postJson(route('workout.store'), $record->getAttributes())
            ->assertCreated()
            ->assertJsonStructure([
                'message', 'workout' => ['exercise_id', 'program_id', 'day', 'reps_based', 'reps', 'time_based', 'time', 'set', 'rest_time']
            ]);
    }

    /**
     * @test
     */
    public function storeWorkoutWithValidDatasAndIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();

        $record = Workout::factory()->program($program)->make();
        $this->actingAs($user2)->postJson(route('workout.store'), $record->getAttributes())
            ->assertForbidden()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function storeWorkoutWithInvalidDatasAndIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();

        $record = Workout::factory()->program($program)->make();
        $record->exercise_id = null;
        $this->actingAs($user)->postJson(route('workout.store'), $record->getAttributes())
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message', 'errors' => ['exercise_id']
            ]);
    }

    /**
     * @test
     */
    public function storeWorkoutWithValidDatasAndNotLogin()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();

        $record = Workout::factory()->program($program)->make();
        $this->postJson(route('workout.store'), $record->getAttributes())
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
