<?php

use Illuminate\Http\Request;
use App\Ticket;

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

// Check in
Route::post('/checkin', 'CheckInController@checkIn');

Route::get('/checkin/search', function (Request $request) {
    $tickets = App\Ticket::search($request->search)->get();
    $return_array = [];

    if ( $tickets ) {
        foreach ( $tickets as $ticket_key => $ticket) {
            $modifiers = [];
            $modifiers = array_map(
                function($modifier) {
                    return $modifier['name'];
                },
                $ticket->modifiers()->get()->toArray()
            );

            $return_array[] = array(
                'id'            => $ticket->id,
                'name'          => $ticket->user()->first()->name,
                'email'         => $ticket->user()->first()->email,
                'code'          => $ticket->ticket_code,
                'ticketType'    => $ticket->ticket_type()->first()->name,
                'modifiers'     => implode(', ', $modifiers),
            );
        }
    }

    return $return_array;
});

// Login
Route::post('login', 'UserController@login');

// User
Route::group(['user' => 'auth:api'], function()
{
   Route::get('users/me', 'UserController@details');
   Route::get('users/tickets', 'UserController@tickets');
});
