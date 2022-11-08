<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/registration', [RegistrationController::class, 'index' ])
        ->name('registration.index');

});
