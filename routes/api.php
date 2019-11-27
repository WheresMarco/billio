<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Organisations
Route::get('/organisations', 'OrganisationController@organisations');

// Events
Route::get('/events', 'EventController@events');

// Tickets
Route::get('/tickets/{id}', 'TicketController@ticket'); // Get ticket by Stripe Source or id
Route::post('/tickets', 'TicketController@create');
Route::patch('/tickets/{id}', 'TicketController@update')->where('id', '[0-9]+');

// Checkstudent
Route::post('/checkstudent', 'CheckStudentController@check');

// User
Route::get('/users/{id}', 'UserController@user')->where('id', '[0-9]+'); // TODO AUTH
