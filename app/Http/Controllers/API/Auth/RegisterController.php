<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\RemoveRequiredEmptyFieldsTrait;
use App\Models\User;

class RegisterController extends Controller
{
    use RemoveRequiredEmptyFieldsTrait;

    public function store(RegisterRequest $request)
    {
        $validated = $request->all();
        $user = User::create($validated);
        $token = $user->createToken($request->email);

        return response()->json([
            'message' => trans('user.register.success'),
            'token' => $token->plainTextToken,
            'user' => new UserResource($user)
        ], 201);
    }

    public function update(UpdateRequest $request)
    {
        $validated = $request->validated();
        $validated = RemoveRequiredEmptyFieldsTrait::removeRequiredEmptyFields($validated, User::$requiredFields);

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->update($validated);

        return response()->json([
            'message' => trans('user.update.success'),
            'user' => new UserResource($user)
        ], 200);
    }

    public function delete()
    {
        /**
         * @var User
         */
        $user = auth()->user();
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'message' => trans('user.delete.success')
        ]);
    }
}
