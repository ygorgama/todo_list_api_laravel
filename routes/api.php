<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('tasks', \App\Http\Controllers\Api\V1\TaskController::class)->middleware(['auth:sanctum']);
Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class)->only(['store']);


Route::post('/login', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'login'])->name('login');
