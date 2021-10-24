<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
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