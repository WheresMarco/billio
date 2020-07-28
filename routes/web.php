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
Nova::routes();

// Home
Route::get('/', 'FrontpageController@index')->name('frontpage');

// Static pages
Route::get('/terms', function () {
    return view('terms');
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

// Event
Route::prefix('event')->group(function () {
    Route::get('{eventSlug}', 'EventController@single')->name('event');
    Route::get('{eventSlug}/{ticketType}', 'PurchaseController@single');
    Route::get('{eventSlug}/{ticketType}/confirmation', 'PurchaseController@confirmation');
});
