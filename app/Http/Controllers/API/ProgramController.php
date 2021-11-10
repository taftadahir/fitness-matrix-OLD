<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\StoreRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;
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

    public function update(Request $request, Program $program)
    {
        //
    }

    public function destroy(Program $program)
    {
        //
    }
}
