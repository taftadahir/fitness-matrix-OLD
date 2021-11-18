<?php

namespace App\Http\Controllers;

use App\Http\Requests\Set\StoreRequest;
use App\Http\Resources\SetResource;
use App\Models\Program;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    public function edit(Set $set)
    {
        //
    }

    public function update(Request $request, Set $set)
    {
        //
    }

    public function destroy(Set $set)
    {
        //
    }
}
