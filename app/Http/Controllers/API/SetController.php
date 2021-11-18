<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Set\StoreRequest;
use App\Http\Requests\UpdateSetRequest;
use App\Http\Resources\SetResource;
use App\Models\Program;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Traits\RemoveRequiredEmptyFieldsTrait;

class SetController extends Controller
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

        /**
         * @var User
         */
        $user = Auth::user();

        if ($user->id != $program->user_id) {
            abort(403, __('auth.forbidden'));
        }

        $record = new Set($validated);
        $program->workouts()->save($record);
        return response()->json(
            [
                'message' => trans('messages.set.create.success'),
                'set' => new SetResource($record)
            ],
            201
        );
    }

    public function show(Set $set)
    {
        // Program is not published and user is not creator => 404
        if (!($set->program->published) && auth()->id() != null && ($set->program->user->id != auth()->id())) {
            throw new NotFoundHttpException();
        }

        return response()->json(
            ['set' => new SetResource($set)]
        );
    }

    public function edit(Set $set)
    {
        //
    }

    public function update(UpdateSetRequest $request, Set $set)
    {
        $validated = $request->validated();


        /**
         * @var User
         */
        $user = Auth::user();

        if ($user->id != $set->program->user_id) {
            abort(403, __('auth.forbidden'));
        }

        $validated = RemoveRequiredEmptyFieldsTrait::removeRequiredEmptyFields($validated, Set::$requiredFields);

        if (array_key_exists('program_id', $validated) && $validated['program_id'] != $set->program_id) {
            $program = Program::where('id', $validated['program_id'])->first();
            $set->program()->associate($program);
        }

        $set->update($validated);
        return response()->json(
            [
                'message' => trans('messages.workout.update.success'),
                'set' => new SetResource($set)
            ],
        );
    }

    public function destroy(Set $set)
    {
        if (auth()->id() != $set->program->user_id) {
            abort(403, __('auth.forbidden'));
        }

        $set->delete();

        return response()->json(
            [
                'message' => trans('messages.set.delete.success'),
            ],
            200
        );
    }
}
