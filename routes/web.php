<?php
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

// Single event
Route::get('/{eventSlug}', 'EventController@single')->name('event');
Route::get('/{eventSlug}/{ticketType}', 'PurchaseController@single');
Route::get('/{eventSlug}/{ticketType}/confirmation', 'PurchaseController@confirmation');
