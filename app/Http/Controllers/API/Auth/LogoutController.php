<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        /**
         * @var User
         */
        $user = Auth::user();
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $user->tokens()->where('id', $token->id)->delete();

        return response()->json([
            'message' => trans('user.logout.success')
        ]);
    }

    public function logoutFromAllDevices()
    {
        /**
         * @var User
         */
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => trans('user.logout_from_all_devices.success')
        ]);
    }
}
