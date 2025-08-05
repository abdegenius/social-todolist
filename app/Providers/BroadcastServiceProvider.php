<?php

namespace App\Providers;

use App\Models\TodoAccess;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Broadcast::routes(['middleware' => ['jwt.auth']]);

        Broadcast::channel('todo.{todoId}', function ($user, $todoId) {
            return TodoAccess::where('user_id', $user->id)
                ->where('todo_id', $todoId)
                ->where('status', '1')
                ->exists();
        });

        require base_path('routes/channels.php');
    }
}
