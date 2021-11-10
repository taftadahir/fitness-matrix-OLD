<?php

namespace Tests\Feature\Exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getExerciseWithValidIdPublished()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Create exercise
        $exercise = Exercise::factory()->published()->create();

        // Get exercise
        $response = $this->actingAs($user)
            ->getJson(route('exercise.show', ['exercise' => $exercise->id]));

        // Assert
        $response->assertOk()
            ->assertJsonStructure(['exercise' => [
                'name', 'time_based', 'reps_based', 'published', 'image', 'created_at', 'updated_at', 'deleted_at'
            ]]);
    }

    /**
     * @test
     */
    public function getExerciseWithValidIdNotPublishedAndNotCreator()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Create user2
        $user2 = new User(User::factory()->make()->getAttributes());
        $user2->save();

        // Create exercise
        $exercise = Exercise::factory()->user($user)->create();

        // Get exercise
        $response = $this->actingAs($user2)
            ->getJson(route('exercise.show', ['exercise' => $exercise->id]));

        // Assert
        $response->assertNotFound()
            ->assertJsonStructure(['message']);
    }

    /**
     * @test
     */
    public function getExerciseWithValidIdNotPublishedAndIsCreator()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Create exercise
        $exercise = Exercise::factory()->create();

        // Get exercise
        $response = $this->actingAs($user)
            ->getJson(route('exercise.show', ['exercise' => $exercise->id]));

        // Assert
        $response->assertOk()
            ->assertJsonStructure(['exercise' => [
                'name', 'time_based', 'reps_based', 'published', 'image', 'created_at', 'updated_at', 'deleted_at'
            ]]);
    }

    /**
     * @test
     */
    public function getExerciseWithInvalidId()
    {
        // Create user
        $user = new User(User::factory()->make()->getAttributes());
        $user->save();

        // Get exercise
        $response = $this->actingAs($user)
            ->getJson(route('exercise.show', ['exercise' => 9000]));

        // Assert
        $response->assertNotFound()
            ->assertJsonStructure(['message']);
    }
}
