<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function showSetWithValidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $response = $this->actingAs($user)
            ->getJson(route('set.show', ['set' => $set->id]));

        $response->assertOk()
            ->assertJsonStructure([
                'set' => [
                    'name', 'program_id', 'day', 'set',
                    'rest_time',
                    'warm_up_set'
                ]
            ]);
    }

    /**
     * @test
     */
    public function showSetWithValidIdIsNotProgramCreatorAndProgramNotPublished()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $response = $this->actingAs($user2)
            ->getJson(route('set.show', ['set' => $set->id]));

        $response->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function showSetWhenNotLogIn()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $set = Set::factory()->program($program)->create();

        $response = $this
            ->getJson(route('set.show', ['set' => $set->id]));

        $response->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
