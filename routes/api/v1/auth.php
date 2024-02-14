<?php

use App\Http\Controllers\Auth\Jwt\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
], static function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
