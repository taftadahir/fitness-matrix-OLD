<?php

namespace Tests\Feature\Workout;

use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getWorkoutWithValidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $response = $this->actingAs($user)
            ->getJson(route('workout.show', ['workout' => $workout->id]));

        $response->assertOk()
            ->assertJsonStructure([
                'workout' => ['exercise_id', 'program_id', 'day', 'reps_based', 'reps', 'time_based', 'time', 'set', 'rest_time']
            ]);
    }

    /**
     * @test
     */
    public function getWorkoutWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $response = $this->actingAs($user)
            ->getJson(route('workout.show', ['workout' => 22]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
