<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/event/create', [EventController::class, 'create' ])
        ->name('events.create');

    Route::get('/event/{slug}', [EventController::class, 'profile' ])
        ->name('event.profile');

    Route::post('/event/store', [EventController::class, 'store' ])
        ->name('event.store');

    // Updating the specific record of the event
    Route::put('/event/{event_id}/updateRecord', [\App\Http\Controllers\EventController::class, 'updateRecord'])
        ->name('updateEventRecord');

});
