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
                return Ticket::find($ticket['id'])->where('status', 'hold')->delete();
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
