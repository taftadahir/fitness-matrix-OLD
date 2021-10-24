<?php

namespace Tests\Feature\Exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeExerciseWithValidDatas()
    {
        $user = User::factory()->admin()->create();
        $exercise = Exercise::factory()->make();
        $this->actingAs($user)->postJson(route('exercise.store'), $exercise->getAttributes())
            ->assertCreated()
            ->assertJsonStructure([
                'message', 'exercise' => ['name', 'time_based', 'reps_based', 'published', 'image']
            ]);
    }

    /**
     * @test
     */
    public function storeExerciseWithInvalidName()
    {
        $user = User::factory()->withConfirmation()->admin()->make();
        $exercise = Exercise::factory()->name(890)->make();
        $this->actingAs($user)->postJson(route('exercise.store'), $exercise->getAttributes())
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message', 'errors' => ['name']
            ]);
    }

    /**
     * @test
     */
    public function storeExerciseWithInvalidToken()
    {
        $exercise = Exercise::factory()->name(890)->make();
        $this->postJson(route('exercise.store'), $exercise->getAttributes())
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
