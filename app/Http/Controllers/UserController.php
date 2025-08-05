<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function profile()
    {
        $user = JWTAuth::user();
        return response()->json(["user" => $user], 200);
    }
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again.'], 500);
        }
    }
    public function search(Request $request)
    {
        $user = JWTAuth::user();
        $username = $request->query('username', '');
        $users = User::where('username', 'like', '%' . $username . '%')
            ->where('id', '!=', $user->id)
            ->limit(10)
            ->get(['id', 'name', 'username']);

        return response()->json($users);
    }
    public function complete_search(Request $request)
    {
        $user = JWTAuth::user();
        $username = $request->query('username', '');
        $user = User::select('id', 'name', 'username')
            ->where('id', '!=', $user->id)
            ->where('username', $username)
            ->first();

        return response()->json($user);
    }
}
