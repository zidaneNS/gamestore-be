<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('games/{game}', [GameController::class, 'show']);
Route::get('games', [GameController::class, 'index']);

Route::get('products', [ProductController::class, 'index']);

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::apiResource('games', GameController::class)->except(['index', 'show']);
    Route::apiResource('products', ProductController::class)->except('index');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});