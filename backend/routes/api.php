<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Catalogs\ClientController;
use App\Http\Controllers\Catalogs\MeasureController;
use App\Http\Controllers\Catalogs\UnitController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ AuthController::class, 'login' ]);
Route::post('/register', [ AuthController::class, 'register' ]);
Route::post('/forgot_password', [ AuthController::class, 'ForgotPassword' ]);
Route::post('/reset_password', [ AuthController::class, 'ResetPassword' ])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [ AuthController::class, 'logout' ]);
    Route::get('get_catalog', [CatalogController::class, 'getCatalog']);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('measures', MeasureController::class);
    Route::apiResource('works', WorkController::class);
});
