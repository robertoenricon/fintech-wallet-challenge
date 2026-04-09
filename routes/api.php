<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me'])->name('api.user.show');
    Route::delete('/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');

    Route::get('/dashboard', function () {
        return response()->json([
            'success' => true,
            'message' => 'Rota protegida com Sanctum.',
            'data' => [
                'authenticated' => true,
            ],
            'error' => null,
        ]);
    })->name('api.dashboard.show');
});
