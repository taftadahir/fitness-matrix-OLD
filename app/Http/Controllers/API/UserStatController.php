<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserStatRequest;
use App\Http\Resources\UserStatResource;
use App\Models\UserStat;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStatController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(CreateUserStatRequest $request)
    {
        $validated = $request->validated();
        $workout = Workout::where('id', $validated['workout_id'])->first();
        $record = new UserStat($validated);
        $record->workout()->associate($workout);

        /**
         * @var User
         */
        $user = Auth::user();

        $user->userStats()->save($record);
        return response()->json(
            [
                'message' => trans('messages.user_stat.create.success'),
                'user_stat' => new UserStatResource($record)
            ],
            201
        );
    }

    public function show(UserStat $userStat)
    {
        //
    }

    public function edit(UserStat $userStat)
    {
        //
    }

    public function update(Request $request, UserStat $userStat)
    {
        //
    }

    public function destroy(UserStat $userStat)
    {
        //
    }
}
