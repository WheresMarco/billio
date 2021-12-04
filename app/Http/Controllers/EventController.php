<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Ticket;

class EventController extends Controller
{
    public function single($eventSlug)
    {
        $event = Event::where('slug', $eventSlug)->first();

        // If have clear cart url parameter, clear cart from session and remove tickets
        if (request()->has('clearcart')) {
            $cart = session()->get('cart');

            foreach ($cart as $ticketId => $ticket) {
                $ticket->delete();
            }

            session()->forget('cart');
        }

        if (! $event) {
            return redirect('/');
        }

        return view('event.single', [
            'event' => $event
        ]);
    }
}
