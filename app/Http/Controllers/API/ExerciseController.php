<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exercise\StoreRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        /**
         * @var User
         */
        $user = Auth::user();
        $exercise = new Exercise($validated);
        $user->exercises()->save($exercise);
        return response()->json(
            [
                'message' => trans('messages.exercise.create.success'),
                'exercise' => new ExerciseResource($exercise)
            ],
            201
        );
    }

    public function show(Exercise $exercise)
    {
        // Exercise is not published and user is not creator => 404
        if ((!$exercise->published) && auth()->id() != null && ($exercise->user->id != auth()->id())) {
            throw new NotFoundHttpException();
        }

        return response()->json(
            ['exercise' => new ExerciseResource($exercise),]
        );
    }

    public function edit(Exercise $exercise)
    {
        //
    }

    public function update(Request $request, Exercise $exercise)
    {
        //
    }

    public function destroy(Exercise $exercise)
    {
        //
    }
}
