<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/promo/store', [PromoController::class, 'store' ])
        ->name('promo.store');

});
