<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/category', [CategoryController::class, 'index' ])
    ->name('category.index');
    
    Route::get('/category/{slug}', [CategoryController::class, 'view' ])
        ->name('category.view');

    Route::post('/category/store', [CategoryController::class, 'store' ])
        ->name('category.store');

    Route::put('/category/update', [CategoryController::class, 'update' ])
        ->name('category.update');

    Route::get('/category/search/{keyword}', [CategoryController::class, 'search' ])
        ->name('category.search');

});