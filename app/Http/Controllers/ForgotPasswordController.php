<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {

       $data = $request->validate([
            'email' => 'required|string'
        ]);
        
        if (! $user = User::firstWhere(['email' => $request->email])) {
            return "Email does not exist.";
        }

        $reset = PasswordReset::createToken($request->email);

        Mail::to($request->email)->send((new PasswordResetMail($user, $reset)));

        Cache::put('user', $data);

        return "Reset password link has been sent to your email.";

    }
}
