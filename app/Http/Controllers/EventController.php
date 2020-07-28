<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Event;

class EventController extends Controller
{
    public function event( Request $request, $slug ) {
        $event = Event::where( 'slug', $slug )->first();

        $return_array = array(
			'id'            => $event->id,
			'name'          => $event->name,
            'slug'          => $event->slug,
            'description'   => $event->description,
            'excerpt'       => $event->excerpt,
            'hero_image'    => Storage::url($event->hero_image),
            'share_image'   => Storage::url($event->share_image),
            'excerpt_image' => Storage::url($event->excerpt_image),
            'organisation'  => $event->organisation()->first(),
            'dates'         => $event->event_dates()->get(),
            'ticketTypes'   => $event->ticket_types()->get()
		);

        return $return_array;
    }

    /**
     * Get all events.
     *
     * @return void
     */
    public function events()
    {
        $events = Event::all();
        $return_array = [];

        if ( $events )
        {
            foreach ( $events as $event_key => $event)
            {
                $return_array[] = array(
                    'id'            => $event->id,
                    'name'          => $event->name,
                    'slug'          => $event->slug,
                    'description'   => $event->description,
                    'excerpt'       => $event->excerpt,
                    'hero_image'    => Storage::url($event->hero_image),
                    'share_image'   => Storage::url($event->share_image),
                    'excerpt_image' => Storage::url($event->excerpt_image),
                    'organisation'  => $event->organisation()->first(),
                    'dates'         => $event->event_dates()->get(),
                    'ticketTypes'   => $event->ticket_types()->get()
                );
            }
        }

        return $return_array;
    }

    public function single()
    {
        return view('event.single');
    }
}
