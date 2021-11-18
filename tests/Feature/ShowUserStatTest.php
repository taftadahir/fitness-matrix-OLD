<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use App\Models\UserStat;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowUserStatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getUserStatWithValidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $response = $this->actingAs($user)
            ->getJson(route('user_stat.show', ['userStat' => $record->id]));

        $response->assertOk()
            ->assertJsonStructure([
                'user_stat' => ['workout_id', 'reps', 'time', 'set']
            ]);
    }

    /**
     * @test
     */
    public function getUserStatWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        UserStat::factory()->user($user)->workout($workout)->create();

        $response = $this->actingAs($user)
            ->getJson(route('user_stat.show', ['userStat' => 22]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function getUserStatWhenNotLogin()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $response = $this
            ->getJson(route('user_stat.show', ['userStat' => $record->id]));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
