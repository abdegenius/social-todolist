<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Todo;
use App\Models\User;
use App\Models\TodoAccess;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoAccessController extends Controller
{
    public function invite(Request $request, Todo $todo)
    {
        $user = JWTAuth::user();
        if ($todo->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'username' => 'required|exists:users,username'
        ]);


        if ($user->username == $request->username) {
            return response()->json(['error' => 'You can not invite yourself'], 422);
        }

        $user = User::where('username', $request->username)->first();

        if ($todo->accesses()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'User already invited'], 400);
        }

        $access = TodoAccess::create([
            'user_id' => $user->id,
            'todo_id' => $todo->id,
            'status' => '0'
        ]);

        return response()->json($access->load('user'), 201);
    }

    public function respond(Request $request, TodoAccess $access)
    {
        $user = JWTAuth::user();
        if ($access->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:1,2'
        ]);

        $access->update(['status' => $request->status]);
        return response()->json($access);
    }

    public function invitations()
    {
        $user = JWTAuth::user();
        $invitations = $user->todo_accesses()
            ->where('status', '0')
            ->with('todo.user')
            ->get();
        return response()->json($invitations);
    }
}
