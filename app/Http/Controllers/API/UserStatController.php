<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserStatRequest;
use App\Http\Requests\UpdateUserStatRequest;
use App\Http\Resources\UserStatResource;
use App\Models\UserStat;
use App\Models\Workout;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\RemoveRequiredEmptyFieldsTrait;

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

    public function update(UpdateUserStatRequest $request, UserStat $userStat)
    {
        $validated = $request->validated();

        /**
         * @var User
         */
        $user = Auth::user();

        if ($user->id != $userStat->user_id) {
            abort(403, __('auth.forbidden'));
        }

        $validated = RemoveRequiredEmptyFieldsTrait::removeRequiredEmptyFields($validated, UserStat::$requiredFields);

        if (array_key_exists('workout_id', $validated) && $validated['workout_id'] != $userStat->workout_id) {
            $workout = Workout::where('id', $validated['workout_id'])->first();
            $userStat->workout()->associate($workout);
        }

        $userStat->update($validated);
        return response()->json(
            [
                'message' => trans('messages.user_stat.update.success'),
                'user_stat' => new UserStatResource($userStat)
            ],
        );
    }

    public function destroy(UserStat $userStat)
    {
        //
    }
}
