<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteSetWithValidTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->create();

        $this->actingAs($user)->deleteJson(
            route('set.destroy', ['set' => $record->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteSetWithValidTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->create();

        $this->actingAs($user2)->deleteJson(
            route('set.destroy', ['set' => $record->id])
        )
            ->assertForbidden()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteSetWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        Set::factory()->program($program)->create();

        $this->actingAs($user)->deleteJson(
            route('set.destroy', ['set' => 88])
        )
            ->assertNotFound()
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * @test
     */
    public function deleteSetWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->user($user)->create();
        $record = Set::factory()->program($program)->create();

        $this->deleteJson(
            route('set.destroy', ['set' => $record->id])
        )
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message',
            ]);
    }
}
