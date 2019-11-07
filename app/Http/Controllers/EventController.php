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

    /**
     * Create an event
     *
     * @return void
     */
    public function create( Request $request )
    {
        // Validate the request...

        $event = new Event;

        $event->name = $request->name;
        $event->description = $request->description;
        $event->organisation_id = $request->organisationID;

        $event->save();

        return $event->id;
    }

    /**
     * Update an event
     *
     * @return void
     */
    public function update( Request $request, int $id )
    {
        // Validate the request...

        $event = Event::find( $id );

        if ( $request->name )
        {
            $event->name = $request->name;
        }

        if ( $request->description )
        {
            $event->description = $request->description;
        }

        if ( $request->organisationID )
        {
            $event->organisation_id = $request->organisationID;
        }

        $event->save();

        return $event->id;
    }

    /**
     * Delete an event
     *
     * @return void
     */
    public function delete( Request $request, int $id )
    {
        $event = Event::find( $id );

        $event->delete();

        return 'Done';
    }
}
