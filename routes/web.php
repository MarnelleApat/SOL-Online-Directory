<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'homepage'])->name('Homepage');
Route::get('/category/{category_slug}', [\App\Http\Controllers\HomeController::class, 'PostByCategory'])->name('PostByCategory');
Route::get('/article/{article_slug}', [\App\Http\Controllers\HomeController::class, 'SingleArticle'])->name('SingleArticle');


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/events', [\App\Http\Controllers\EventController::class, 'index' ])->middleware(['auth', 'verified'])->name('events.index');
Route::get('/event/create', [\App\Http\Controllers\EventController::class, 'create' ])->middleware(['auth', 'verified'])->name('events.create');
Route::get('/event/{slug}', [\App\Http\Controllers\EventController::class, 'profile' ])->middleware(['auth', 'verified'])->name('event.profile');
Route::get('/partners', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('partners.index');
Route::get('/partner/{slug}', [\App\Http\Controllers\DashboardController::class, 'profile' ])->middleware(['auth', 'verified'])->name('partner.profile');
Route::get('/registrants', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('registrants.index');
Route::get('/users', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('users.index');
Route::get('/settings', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('settings');
Route::get('/partners', [\App\Http\Controllers\DepartmentController::class, 'index' ])->middleware(['auth', 'verified'])->name('partners.index');
Route::get('/partners/create', [\App\Http\Controllers\DepartmentController::class, 'create' ])->middleware(['auth', 'verified'])->name('partners.create');



require __DIR__.'/auth.php';
