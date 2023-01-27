<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;

class EventController extends Controller
{
    public function single($eventSlug)
    {
        // If have clear cart url parameter, clear cart from session and remove tickets
        if (request()->has('clearcart')) {
            $cart = session()->get('cart');

            collect($cart)->map(function ($ticket) {
                // Get ticket by id and if status is hold, delete it
                if ($ticket = Ticket::find($ticket->id)) {
                    if ($ticket->status === 'hold') {
                        $ticket->delete();
                    }
                }

                return;
            });

            session()->forget('cart');
        }

        if (!$event = Event::where('slug', $eventSlug)->first()) {
            return redirect('/');
        }

        return view('event.single', [
            'event' => $event,
        ]);
    }
}
