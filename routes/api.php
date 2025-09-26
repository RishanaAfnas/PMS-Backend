<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum','log.request')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/me',[AuthController::class,'me']);

    Route::middleware('role:admin')->group(function(){
        Route::apiResource('projects',ProjectController::class);
    });

    Route::middleware('role:manager')->group(function(){
        Route::apiResource('projects.tasks',TaskController::class)->shallow();
    });

    Route::middleware('role:user,manager')->group(function(){
        Route::apiResource('tasks.comments',CommentController::class)->shallow();
    });
});