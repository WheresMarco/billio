<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;

class EventController extends Controller
{
    public function single($eventSlug)
    {
        if (!$event = Event::where('slug', $eventSlug)->first()) {
            return redirect('/');
        }

        return view('event.single', [
            'event' => $event,
        ]);
    }
}
