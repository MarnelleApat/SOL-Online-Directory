<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdministratorDashboard;


Route::group(['middleware' => 'checkRole:Administrator'], function() {
    Route::get('/administrator/dashboard', [AdministratorDashboard::class, 'home'])->name('admin.dashboard');
    Route::get('/administrator/events', [EventController::class, 'index'])->name('admin.events');
    Route::get('/administrator/event/{slug}', [EventController::class, 'eventProfile'])->name('admin.eventProfile');
    Route::get('/administrator/events/create', [EventController::class, 'create'])->name('admin.eventCreate');

    Route::get('/administrator/events/search', [EventController::class, 'searchEvents'])->name('admin.eventSearch');

    Route::get('/administrator', function() {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/administrator/event', function() {
        return redirect()->route('admin.events');
    });

});
