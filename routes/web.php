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
Route::get('/', 'HomeController@index')->name('home');

// Single event
Route::get('/event', 'EventController@single')->name('event');

// Purchase
Route::get('/event/fest', 'PurchaseController@single');
Route::get('/event/fest/confirmation', 'PurchaseController@confirmation');
