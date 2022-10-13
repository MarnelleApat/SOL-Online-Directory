<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/partners', [DepartmentController::class, 'index' ])
        ->name('partners.index');

    Route::get('/partners/create', [DepartmentController::class, 'create' ])
        ->name('partners.create');

    Route::post('/partners/store', [DepartmentController::class, 'store' ])
        ->name('partners.store');

    Route::put('/partners/update', [DepartmentController::class, 'update' ])
        ->name('partners.update');

    Route::get('/partners/{slug}', [DepartmentController::class, 'view' ])
        ->name('partners.view');

    Route::get('/partners/search', [DepartmentController::class, 'search' ])
        ->name('partners.search');

});
