<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;

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

// Checkstudent
Route::post('/checkstudent', 'CheckStudentController@check');

// Check in
Route::post('/checkin', 'CheckInController@checkIn');

// Search
Route::get('/checkin/search', 'CheckInController@search');
