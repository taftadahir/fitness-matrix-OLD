<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\StoreRequest;
use App\Http\Requests\Program\UpdateRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Traits\RemoveRequiredEmptyFieldsTrait;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProgramController extends Controller
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
        $record = new Program($validated);
        $user->programs()->save($record);

        return response()->json(
            [
                'message' => trans('messages.exercise.create.success'),
                'program' => new ProgramResource($record)
            ],
            201
        );
    }

    public function show(Program $program)
    {
        // Program is not published and user is not creator => 404
        if ((!$program->published) && auth()->id() != null && ($program->user->id != auth()->id())) {
            throw new NotFoundHttpException();
        }

        return response()->json(
            ['program' => new ProgramResource($program),]
        );
    }

    public function edit(Program $program)
    {
        //
    }

    public function update(UpdateRequest $request, Program $program)
    {
        if (auth()->id() != $program->user_id) {
            abort(403, __('auth.forbidden'));
        }

        $validated = $request->validated();
        $validated = RemoveRequiredEmptyFieldsTrait::removeRequiredEmptyFields($validated, Program::$requiredFields);
        $program->update($validated);

        return response()->json(
            [
                'message' => trans('messages.program.update.success'),
                'program' => new ProgramResource($program)
            ],
            200
        );
    }

    public function destroy(Program $program)
    {
        //
    }
}
