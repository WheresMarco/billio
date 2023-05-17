<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
Route::stripeWebhooks('/stripe/{configKey}');
Auth::routes();

// Home
Route::get('/', 'FrontpageController@index')->name('frontpage')->middleware('clearcart');
Route::view('/about', 'about')->middleware('clearcart');
Route::view('/contact', 'contact')->middleware('clearcart');
Route::view('/terms', 'terms');
Route::view('/privacy-policy', 'privacy')->middleware('clearcart');
Route::view('/help', 'help')->middleware('clearcart');

// Check in
Route::get('/checkin', [
    'as' => 'checkin',
    'uses' => 'CheckInController@index',
    'middleware' => 'auth.very_basic:sof,kul'
]);

// Event
Route::prefix('event')->group(function () {
    Route::get('{eventSlug}', 'EventController@single')->name('event')->middleware('accesscode', 'clearcart');

    Route::post('{eventSlug}/donate', 'DonationController@addToCart');
    Route::get('{eventSlug}/donate/payment', 'DonationController@payment');
    Route::post('{eventSlug}/donate/payment', 'DonationController@createPaymentIntent');
    Route::get('{eventSlug}/donate/confirmation', 'DonationController@confirmation');

    Route::post('{eventSlug}/{ticketType}', 'PurchaseController@addToCart')->middleware('isactivetickettype');

    Route::get('{eventSlug}/{ticketType}/info', 'PurchaseController@info')->middleware('isactivetickettype');
    Route::post('{eventSlug}/{ticketType}/info', 'PurchaseController@updateCartWithTicketInfo')->middleware('isactivetickettype');

    Route::get('{eventSlug}/{ticketType}/payment', 'PurchaseController@payment')->middleware('isactivetickettype');
    Route::post('{eventSlug}/{ticketType}/payment', 'PurchaseController@createPaymentIntent')->middleware('isactivetickettype');

    Route::get('{eventSlug}/{ticketType}/confirmation', 'PurchaseController@confirmation')->middleware('isactivetickettype');
});

// QR Code
Route::get('/code/{qrCode}', function ($qrcode) {
    $qrcode = preg_replace('/[^A-Za-z0-9\-]/', '', $qrcode);
    return response()->file(QrCode::size(800)->format('png')->generate($qrcode));
});

Nova::routes();
