<?php

namespace Tests\Feature\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateProgramWithValidDataTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->create();

        $this->actingAs($user)->putJson(
            route('program.update', ['program' => $record->id]),
            $record->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'message', 'program' => ['name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image']
            ]);
    }

    /**
     * @test
     */
    public function updateProgramWithValidDataTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $record = Program::factory()->user($user)->create();

        $this->actingAs($user2)->putJson(
            route('program.update', ['program' => $record->id]),
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
    public function updateProgramWithInvalidIdValidDataToken()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $record = Program::factory()->user($user)->create();

        $this->actingAs($user2)->putJson(
            route('program.update', ['program' => 22]),
            $record->getAttributes()
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function updateProgramWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->user($user)->create();

        $this->putJson(
            route('program.update', ['program' => $record->id]),
            $record->getAttributes()
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
