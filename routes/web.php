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

// Publich Routes
Route::get('/events/{slug}', [\App\Http\Controllers\HomeController::class, 'eventPage'])->name('event.public');
Route::post('/register/{event_id}', [\App\Http\Controllers\RegistrationController::class, 'register' ])->name('register.event');

Route::get('/validatePromo/{event_id}/{promocode}', [\App\Http\Controllers\PromoController::class, 'validatePromo'])->name('promo.validate');

Route::get('/', [\App\Http\Controllers\HomeController::class, 'homepage'])->name('Homepage');
Route::post('/donate', [\App\Http\Controllers\HomeController::class, 'donate'])->name('donate');
Route::get('/success', [\App\Http\Controllers\HomeController::class, 'success'])->name('success');
Route::get('/cancel', [\App\Http\Controllers\HomeController::class, 'cancel'])->name('cancel');

// Authenticated Routes
Route::get('/article/{article_slug}', [\App\Http\Controllers\HomeController::class, 'SingleArticle'])->name('SingleArticle');
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/registrants', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('registrants.index');
Route::get('/users', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('users.index');
Route::get('/settings', [\App\Http\Controllers\DashboardController::class, 'index' ])->middleware(['auth', 'verified'])->name('settings');
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index' ])->middleware(['auth', 'verified'])->name('categories.index');

require __DIR__.'/EventRoutes.php';

require __DIR__.'/PartnerRoutes.php';

require __DIR__.'/CategoryRoutes.php';

require __DIR__.'/PromoRoutes.php';

require __DIR__.'/RegistrationRoutes.php';

require __DIR__.'/auth.php';
