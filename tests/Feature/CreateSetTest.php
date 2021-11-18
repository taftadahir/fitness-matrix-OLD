<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function createSetWithValidDatas()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->make();
        $this->actingAs($user)->postJson(route('set.store'), $record->getAttributes())
            ->assertCreated()
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
    public function createSetWithValidDatasAndIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->make();
        $this->actingAs($user2)->postJson(route('set.store'), $record->getAttributes())
            ->assertForbidden()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function createSetWithInvalidDatas()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->make();
        $record->program_id = null;
        $this->actingAs($user)->postJson(route('set.store'), $record->getAttributes())
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message', 'errors' => ['program_id']
            ]);
    }

    /**
     * @test
     */
    public function createSetWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->make();
        $this->postJson(route('set.store'), $record->getAttributes())
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
