<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisteredUserController extends Controller
{
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
}
