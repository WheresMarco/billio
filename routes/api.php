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
Route::get('/events/{slug}', 'EventController@event');

// Tickets
Route::get('/tickets/{id}', 'TicketController@ticket'); // Get ticket by uuid
Route::post('/tickets', 'TicketController@create');

// Checkstudent
Route::post('/checkstudent', 'CheckStudentController@check');

// Login
Route::post('login', 'UserController@login');

// User
Route::group(['user' => 'auth:api'], function()
{
   Route::get('users/me', 'UserController@details');
   Route::get('users/tickets', 'UserController@tickets');
});

Route::get('testsend', 'TicketController@testsend');
