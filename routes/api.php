<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum', 'verified']], function(){

    // api for get all media
    Route::get('/media/all', [\App\Http\Controllers\MediaController::class, 'all' ])
        ->name('allMedia.api');

    // api for Get all categories
    Route::get('/categories/all', [\App\Http\Controllers\CategoryController::class, 'all' ])
        ->name('allCategories.api');

    // api for Get all Speakers
    Route::get('/speakers/all', [\App\Http\Controllers\SpeakerController::class, 'all' ])
        ->name('allSpeakers.api');

    // api for updating the specific record of the event
    // Route::post('/event/updateRecord', [\App\Http\Controllers\EventController::class, 'updateRecord'])
    //     ->name('updateEventRecord.api');

});
