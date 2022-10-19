<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/category', [CategoryController::class, 'index' ])
    ->name('category.index');
    
    Route::get('/category/{slug}', [CategoryController::class, 'view' ])
        ->name('category.view');

    Route::post('/category/store', [DepartmentController::class, 'store' ])
        ->name('category.store');

    Route::put('/category/update', [DepartmentController::class, 'update' ])
        ->name('category.update');

    Route::get('/category/search/{keyword}', [DepartmentController::class, 'search' ])
        ->name('category.search');

});