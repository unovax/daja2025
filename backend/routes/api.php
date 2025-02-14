<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Catalogs\ClientController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ AuthController::class, 'login' ]);
Route::post('/register', [ AuthController::class, 'register' ]);
Route::post('/forgot_password', [ AuthController::class, 'ForgotPassword' ]);
Route::post('/reset_password', [ AuthController::class, 'ResetPassword' ])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [ AuthController::class, 'logout' ]);
    Route::apiResource('clients', ClientController::class);
});
