<?php

use App\Http\Controllers\Api\v1\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'products',
], static function () {
    Route::get('/', [ProductsController::class, 'index']);
    Route::get('/{id}', [ProductsController::class, 'show']);
    Route::post('/', [ProductsController::class, 'store']);
    Route::put('/{id}', [ProductsController::class, 'update']);
    Route::delete('/{id}', [ProductsController::class, 'destroy']);
});
