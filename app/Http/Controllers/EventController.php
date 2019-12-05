<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function event( Request $request, $slug ) {
        $event = Event::where( 'slug', $slug )->first();

        $event['organisation'] = $event->organisation()->first();
        unset( $event['organisation_id'] );

        $event['dates']       = $event->event_dates()->get();
        $event['ticketTypes'] = $event->ticket_types()->get();

        return $event;
    }

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

                $events[ $event_key]['dates']       = $event->event_dates()->get();
                $events[ $event_key]['ticketTypes'] = $event->ticket_types()->get();
            }
        }

        return $events;
    }
}
