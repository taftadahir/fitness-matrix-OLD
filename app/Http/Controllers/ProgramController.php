<?php

namespace App\Http\Controllers;

use App\Http\Requests\Program\StoreRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
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
