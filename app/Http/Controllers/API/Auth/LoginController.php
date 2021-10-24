<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        /**
         * @var App\Model\User 
         */
        $user = auth()->user();

        $token = $user->createToken($request->email);
        return response()->json([
            'message' => trans('user.login.success'),
            'token' => $token->plainTextToken,
            'user' => new UserResource($user)
        ], 200);
    }
}
