<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use App\Models\UserStat;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserStatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeUserStatWithValidDatas()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $record = UserStat::factory()->workout($workout)->make();
        $this->actingAs($user)->postJson(route('user_stat.store'), $record->getAttributes())
            ->assertCreated()
            ->assertJsonStructure([
                'message', 'user_stat' => ['workout_id', 'reps', 'time', 'set']
            ]);
    }

    /**
     * @test
     */
    public function storeUserStatWithInvalidDatas()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $record = UserStat::factory()->workout($workout)->make();
        $record->workout_id = null;

        $this->actingAs($user)->postJson(route('user_stat.store'), $record->getAttributes())
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message', 'errors' => ['workout_id']
            ]);
    }

    /**
     * @test
     */
    public function storeUserStatWhenNotLogin()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $record = UserStat::factory()->workout($workout)->make();
        $record->workout_id = null;

        $this->postJson(route('user_stat.store'), $record->getAttributes())
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
