<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/events', [EventController::class, 'index' ])
        ->name('events.index');

    Route::get('/event/create', [EventController::class, 'create' ])
        ->name('events.create');

    Route::get('/event/{slug}', [EventController::class, 'profile' ])
        ->name('event.profile');

    Route::post('/event/store', [EventController::class, 'store' ])
        ->name('event.store');

});
