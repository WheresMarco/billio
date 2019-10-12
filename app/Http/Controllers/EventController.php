<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    /**
     * Get all events.
     *
     * @return void
     */
    public function events()
    {
        $events = Event::all();

        if ( $events )
        {
            foreach ( $events as $event_key => $event)
            {
                $events[ $event_key]['organisation'] = $event->organisation()->first();
                unset( $events[ $event_key] ['organisation_id'] );

                $events[ $event_key]['dates'] = $event->dates()->get();
            }
        }

        return $events;
    }
}
