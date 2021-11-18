<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateSetWithValidDataTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $this->actingAs($user)->putJson(
            route('set.update', ['set' => $set->id]),
            $set->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'message', 'set' => [
                    'name', 'program_id', 'day', 'set',
                    'rest_time',
                    'warm_up_set'
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateSetWithValidDataTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $this->actingAs($user2)->putJson(
            route('set.update', ['set' => $set->id]),
            $set->getAttributes()
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function updateSetWithValidDataTokenIsProgramCreatorAndInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $this->actingAs($user)->putJson(
            route('set.update', ['set' => 9000000]),
            $set->getAttributes()
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function updateSetWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $this->putJson(
            route('set.update', ['set' => $set->id]),
            $set->getAttributes()
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
