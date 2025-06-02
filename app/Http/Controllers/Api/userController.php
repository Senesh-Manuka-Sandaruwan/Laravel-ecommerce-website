<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Get user details from middleware attribute
    public function getUserDetails(Request $request)
    {
        $user = $request->attributes->get('user');
        if (!$user || !$user->tokenable_id) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $userDetails = User::find($user->tokenable_id);
        if (!$userDetails) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['user' => $userDetails]);
    }
}
