<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::get('/check', function (Request $request) {
    return Response::json(["success" => true], 200);
});

Route::resource('tasks', TaskController::class);
Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus']);
