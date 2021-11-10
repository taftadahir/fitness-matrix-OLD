<?php

namespace Tests\Feature\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getProgramWithValidIdPublished()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Create Program
        $program = Program::factory()->published()->create();

        // Get program
        $response = $this->actingAs($user)
            ->getJson(route('program.show', ['program' => $program->id]));

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure(['program' => [
                'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image', 'created_at', 'updated_at', 'deleted_at'
            ],],);
    }

    /**
     * @test
     */
    public function getProgramWithValidIdNotPublishedAndNotCreator()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Create user2
        $user2 = new User(User::factory()->make()->getAttributes());
        $user2->save();

        // Create program
        $program = Program::factory()->user($user)->create();

        // Get program
        $response = $this->actingAs($user2)
            ->getJson(route('program.show', ['program' => $program->id]));

        // Assert
        $response->assertNotFound()
            ->assertJsonStructure(['message']);
    }

    /**
     * @test
     */
    public function getProgramWithValidIdNotPublishedAndIsCreator()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Create program
        $program = Program::factory()->create();

        // Get program
        $response = $this->actingAs($user)
            ->getJson(route('program.show', ['program' => $program->id]));

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure(['program' => [
                'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image', 'created_at', 'updated_at', 'deleted_at'
            ]]);
    }

    /**
     * @test
     */
    public function getProgramWithInvalidId()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Get program
        $response = $this->actingAs($user)
            ->getJson(route('program.show', ['program' => 9000]));

        // Assert
        $response
            ->assertNotFound()
            ->assertJsonStructure(['message']);
    }
}
