<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
            'otp' => ['nullable', 'numeric', 'digits:6'],
        ]);

        $reset = PasswordReset::verifyToken($request->token);

        $user = User::whereEmail($reset->email)->first();

        if (! $user) {
            return "User not found";
        }

        if (Hash::check($request->password, $user->password)) {
            return "Sorry you can't use your old password";
        }

        $user->update(['password' => Hash::make($request->password)]);

        return "Password reset successfully";
    }

       /**
     * Verifies Password Reset Token.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPasswordToken(string $token)
    {
        $passwordReset = PasswordReset::verifyToken($token);

        if (! $passwordReset) {
            return $this->badRequestResponse('Invalid token or expired token');
        }

        if (! $user = User::firstWhere(['email' => $passwordReset->email])) {
            return response()->json([
                'message' => 'User Not Found'
            ]);
        }

    }
}

