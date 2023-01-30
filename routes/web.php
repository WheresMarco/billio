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
Route::get('/', 'FrontpageController@index')->name('frontpage')->middleware('clearcart');
Route::view('/about', 'about')->middleware('clearcart');
Route::view('/contact', 'contact')->middleware('clearcart');
Route::view('/terms', 'terms');
Route::view('/privacy-policy', 'privacy')->middleware('clearcart');
Route::view('/help', 'help')->middleware('clearcart');

// Event
Route::prefix('event')->group(function () {
    Route::get('{eventSlug}', 'EventController@single')->name('event')->middleware('accesscode', 'clearcart');

    Route::post('{eventSlug}/{ticketType}', 'PurchaseController@addToCart')->middleware('isactivetickettype');

    Route::get('{eventSlug}/{ticketType}/info', 'PurchaseController@info')->middleware('isactivetickettype');
    Route::post('{eventSlug}/{ticketType}/info', 'PurchaseController@updateCartWithTicketInfo')->middleware('isactivetickettype');

    Route::get('{eventSlug}/{ticketType}/payment', 'PurchaseController@payment')->middleware('isactivetickettype');
    Route::post('{eventSlug}/{ticketType}/payment', 'PurchaseController@createPaymentIntent')->middleware('isactivetickettype');

    Route::get('{eventSlug}/{ticketType}/confirmation', 'PurchaseController@confirmation')->middleware('isactivetickettype');
});

Nova::routes();
