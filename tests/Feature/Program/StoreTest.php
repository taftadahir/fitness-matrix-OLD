<?php

namespace Tests\Feature\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeProgramWithValidDatas()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->make();
        $this->actingAs($user)->postJson(route('program.store'), $record->getAttributes())
            ->assertCreated()
            ->assertJsonStructure([
                'message', 'program' => ['name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image']
            ]);
    }

    /**
     * @test
     */
    public function storeProgramWithInvalidDatas()
    {
        $user = User::factory()->withConfirmation()->admin()->make();
        $record = Program::factory()->name(890)->make();
        $this->actingAs($user)->postJson(route('program.store'), $record->getAttributes())
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message', 'errors' => ['name']
            ]);
    }

    /**
     * @test
     */
    public function storeProgramWithInvalidToken()
    {
        $record = Program::factory()->make();
        $this->postJson(route('program.store'), $record->getAttributes())
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
