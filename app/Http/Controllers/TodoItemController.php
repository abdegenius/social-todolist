<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Todo;
use App\Models\TodoItem;
use App\Events\TodoItemCreated;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoItemController extends Controller
{
    public function store(Request $request, Todo $todo)
    {
        $user = JWTAuth::user();
        if (!$todo->accesses()->where('user_id', $user->id)->where('status', '1')->exists()) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $request->validate([
            'content' => 'required|string'
        ]);

        $item = TodoItem::create([
            'user_id' => $user->id,
            'todo_id' => $todo->id,
            'content' => $request->content
        ]);

        event(new TodoItemCreated($item));

        return response()->json($item->load('user'), 201);
    }

    public function update(Request $request, TodoItem $item)
    {
        $user = JWTAuth::user();
        if ($item->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:1,0'
        ]);

        $item->update(['status' => $request->status]);
        return response()->json($item);
    }

    public function destroy(TodoItem $item)
    {
        $user = JWTAuth::user();
        if ($item->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $item->delete();
        return response()->json(null, 204);
    }
}
