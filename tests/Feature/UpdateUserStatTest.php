<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use App\Models\UserStat;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserStatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateUserStatWithValidDataTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->actingAs($user)->putJson(
            route('user_stat.update', ['userStat' => $record->id]),
            $record->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'message', 'user_stat' => ['workout_id', 'reps', 'time', 'set']
            ]);
    }

    /**
     * @test
     */
    public function updateUserStatWithValidDataTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->actingAs($user2)->putJson(
            route('user_stat.update', ['userStat' => $record->id]),
            $record->getAttributes()
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function updateUserStatWithValidDataTokenInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->actingAs($user)->putJson(
            route('user_stat.update', ['userStat' => 90]),
            $record->getAttributes()
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function updateUserStatWithValidDataInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->putJson(
            route('user_stat.update', ['userStat' => $record->id]),
            $record->getAttributes()
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
