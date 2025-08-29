<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login_post']);
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::middleware('auth:sanctum')->group(function ()
{
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/login', [AuthController::class, 'login_get'])->name('login');

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::apiResource('posts', PostController::class);
});