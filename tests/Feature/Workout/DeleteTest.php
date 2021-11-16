<?php

namespace Tests\Feature\Workout;

use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteWorkoutWithValidTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Workout::factory()->program($program)->create();

        $this->actingAs($user)->deleteJson(
            route('workout.destroy', ['workout' => $record->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteWorkoutWithValidTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $record = Workout::factory()->program($program)->create();

        $this->actingAs($user2)->deleteJson(
            route('workout.destroy', ['workout' => $record->id])
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteWorkoutWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        Workout::factory()->program($program)->create();

        $this->actingAs($user)->deleteJson(
            route('workout.destroy', ['workout' => 88])
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteWorkoutWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Workout::factory()->program($program)->create();

        $this->deleteJson(
            route('workout.destroy', ['workout' => $record->id])
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
