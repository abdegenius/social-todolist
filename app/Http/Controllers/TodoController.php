<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\TodoAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoController extends Controller
{
    public function store(Request $request)
    {

        $user = JWTAuth::user();
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $todo = Todo::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'code' => Str::random(10)
        ]);

        TodoAccess::create([
            'user_id' => $user->id,
            'todo_id' => $todo->id,
            'status' => '1'
        ]);

        return response()->json($todo, 201);
    }

    public function index()
    {
        $user = JWTAuth::user();
        $todos = $user->accessible_todos()->with('user', 'items', 'accesses.user')->get();
        return response()->json($todos);
        // $userId = $user->id;

        // $todos = Todo::with(['user', 'items', 'accesses' => function ($query) use ($userId) {
        //     $query->where('user_id', $userId)->where('status', '1');
        // }])
        //     ->whereHas('accesses', function ($query) use ($userId) {
        //         $query->where('user_id', $userId)->where('status', '1');
        //     })
        //     ->get();

        // $todos->each(function ($todo) use ($userId) {
        //     $todo->setRelation('pivot', $todo->accesses->firstWhere('user_id', $userId));
        //     unset($todo->accesses); 
        // });

        // return response()->json($todos);
    }


    public function show(Todo $todo)
    {
        $user = JWTAuth::user();
        if (!$todo->accesses()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $todo->load(['items.user', 'accesses.user']);
        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $user = JWTAuth::user();
        if ($todo->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $todo->delete();
        return response()->json(null, 204);
    }
}
