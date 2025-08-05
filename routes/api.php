<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    TodoController,
    TodoItemController,
    UserController,
    TodoAccessController
};

Route::group(['middleware' => 'json.response'], function () {
    // Register
    Route::post('/register', [AuthController::class, 'register']);
    // Login
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('jwt.auth')->group(function () {
        // View profile
        Route::get('users/profile', [UserController::class, 'profile']);
        // Log out
        Route::post('users/logout', [UserController::class, 'logout']);

        // Todo Lists
        Route::apiResource('todos', TodoController::class)->except(['update']);

        // Todo Items
        Route::post('todos/{todo}/items', [TodoItemController::class, 'store']);
        Route::put('items/{item}', [TodoItemController::class, 'update']);
        Route::delete('items/{item}', [TodoItemController::class, 'destroy']);

        // User Search
        Route::get('users/search', [UserController::class, 'search']);
        Route::get('users/complete-search', [UserController::class, 'complete_search']);

        // Todo Access Management
        Route::post('todos/{todo}/invite', [TodoAccessController::class, 'invite']);
        Route::put('accesses/{access}', [TodoAccessController::class, 'respond']);
        Route::get('invitations', [TodoAccessController::class, 'invitations']);
    });
});
