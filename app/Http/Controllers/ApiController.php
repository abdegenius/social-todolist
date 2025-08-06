<?php

namespace App\Http\Controllers;

use App\Models\TodoAccess;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    public function dashboard_summary()
    {
        $user = JWTAuth::user();
        $accesses = TodoAccess::where('user_id', $user->id)
            ->where('status', '1')
            ->with('todo.items')
            ->get();

        $totalTodos = $accesses->count();
        $totalCompleted = 0;
        $totalPending = 0;

        foreach ($accesses as $access) {
            if (!$access->todo || !$access->todo->items) continue;

            foreach ($access->todo->items as $item) {
                if ($item->status === '1') {
                    $totalCompleted++;
                } else {
                    $totalPending++;
                }
            }
        }

        return response()->json([
            'total_accessible_todos' => $totalTodos,
            'completed_items' => $totalCompleted,
            'pending_items' => $totalPending,
        ]);
    }
}
