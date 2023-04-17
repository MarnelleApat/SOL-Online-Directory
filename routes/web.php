<?php

use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
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

Route::group(['middleware' => 'auth'], function() {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

    require __DIR__.'/Administrator.php';

    require __DIR__.'/AdminUser.php';

    require __DIR__.'/User.php';

});



// Publich Routes
Route::get('/', [\App\Http\Controllers\HomeController::class, 'homepage'])->name('Homepage');
Route::get('/events', [\App\Http\Controllers\EventController::class, 'list' ])->name('events.list');
Route::get('/events/{slug}', [\App\Http\Controllers\EventController::class, 'single'])->name('singleEvent.public');
Route::get('/events/{programCode}/register', [\App\Http\Controllers\EventController::class, 'guestRegister'])->name('register.guest');


Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store' ])->name('checkout');
Route::get('/success', [\App\Http\Controllers\OrderController::class, 'success'])->name('success');
Route::get('/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('cancel');
Route::get('/thankyou', [\App\Http\Controllers\OrderController::class, 'thankyou'])->name('thankyou');


Route::get('/validatePromo/{programCode}/{promocode}', [\App\Http\Controllers\PromoController::class, 'validatePromo'])->name('promo.validate');

// TO BE DELETED
Route::post('/register/{event_id}', [\App\Http\Controllers\RegistrationController::class, 'registerCustomer' ])->name('register.event');



// ---------
Route::post('/processPayment', [\App\Http\Controllers\HomeController::class, 'processPayment'])->name('processPayment');
Route::post('/donate', [\App\Http\Controllers\HomeController::class, 'donate'])->name('donate');
// ---------


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


// custom 404 page
Route::get('/not-found', [\App\Http\Controllers\HomeController::class, 'NotFound'])->name('notFound');
