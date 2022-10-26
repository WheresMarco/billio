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

Route::stripeWebhooks('/webhook/stripe');
Auth::routes();

// Home
Route::get('/', 'FrontpageController@index')->name('frontpage');

// Static pages
Route::get('/terms', function () {
    return view('terms');
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

Route::get('/help', function () {
    return view('help');
});

// Event
Route::prefix('event')->group(function () {
    Route::get('{eventSlug}', 'EventController@single')->name('event');

    Route::post('{eventSlug}/{ticketType}', 'PurchaseController@addToCart');

    Route::get('{eventSlug}/{ticketType}/seating', 'PurchaseController@selectSeating');

    Route::get('{eventSlug}/{ticketType}/info', 'PurchaseController@info');
    Route::post('{eventSlug}/{ticketType}/info', 'PurchaseController@updateCartWithTicketInfo');

    Route::get('{eventSlug}/{ticketType}/payment', 'PurchaseController@payment');
    Route::post('{eventSlug}/{ticketType}/payment', 'PurchaseController@createPaymentIntent');

    Route::get('{eventSlug}/{ticketType}/confirmation', 'PurchaseController@confirmation');
});

Nova::routes();
