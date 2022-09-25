<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();




Route::group(["alias" => "payment", "middleware" => "auth"], function () {

    Route::get('/subscriptions/{amount}/{package_id}', [PaymentController::class, 'index'])->name('payment-init');

    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment-checkout');

    Route::get('/payment/status', [PaymentController::class, 'status'])->name('payment-status');
});

Route::group(["alias" => "dashboard", "middleware" => "auth"], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');

    Route::get('/logout', function () {
        Auth::logout();
        Session::flush();
        return redirect("/");
    });
});
