<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Event;

class EventController extends Controller
{
    public function single($eventSlug)
    {
        $event = Event::where('slug', $eventSlug)->first();

        if (! $event) {
            return redirect('/');
        }

        return view('event.single', [
            'event' => $event
        ]);
    }
}
