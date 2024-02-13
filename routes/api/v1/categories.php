<?php

use App\Http\Controllers\Api\v1\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'categories',
], static function () {
    Route::get('/', [CategoriesController::class, 'index']);
    Route::get('/{id}', [CategoriesController::class, 'show']);
    Route::post('/', [CategoriesController::class, 'store']);
    Route::put('/{id}', [CategoriesController::class, 'update']);
    Route::delete('/{id}', [CategoriesController::class, 'destroy']);
});
