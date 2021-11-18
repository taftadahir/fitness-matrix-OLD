<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use App\Models\UserStat;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUserStatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteUserStatWithValidTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->actingAs($user)->deleteJson(
            route('user_stat.destroy', ['userStat' => $record->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteUserStatWithValidTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->actingAs($user2)->deleteJson(
            route('user_stat.destroy', ['userStat' => $record->id])
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteUserStatWithInvalidIdIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->actingAs($user)->deleteJson(
            route('user_stat.destroy', ['userStat' => 22])
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteUserStatWithInvalidtokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $workout = Workout::factory()->program($program)->create();
        $record = UserStat::factory()->user($user)->workout($workout)->create();

        $this->deleteJson(
            route('user_stat.destroy', ['userStat' => $record->id])
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
