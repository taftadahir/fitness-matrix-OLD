<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workout\StoreRequest;
use App\Http\Resources\WorkoutResource;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class WorkoutController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $program = Program::where('id', $validated['program_id'])->first();
        $exercise = Exercise::where('id', $validated['exercise_id'])->first();

        /**
         * @var User
         */
        $user = Auth::user();

        if ($user->id != $program->user_id) {
            abort(403, __('auth.forbidden'));
        }

        $record = new Workout($validated);
        $record->exercise()->associate($exercise);
        $program->workouts()->save($record);
        return response()->json(
            [
                'message' => trans('messages.workout.create.success'),
                'workout' => new WorkoutResource($record)
            ],
            201
        );
    }

    public function show(Workout $workout)
    {
        //
    }

    public function edit(Workout $workout)
    {
        //
    }

    public function update(Request $request, Workout $workout)
    {
        //
    }

    public function destroy(Workout $workout)
    {
        //
    }
}
