<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'checkRole:User'], function() {
    Route::get('/user/dashboard', [\App\Http\Controllers\UserDashboard::class, 'home'])->name('user.dashboard');

    Route::get('/user', function() {
        return redirect()->route('userDashboard');
    });

});
