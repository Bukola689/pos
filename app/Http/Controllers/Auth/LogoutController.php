<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(User $user)
    {
        $user = $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully !'
        ]);
    }
}
