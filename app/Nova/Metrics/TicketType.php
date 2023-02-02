<?php

namespace App\Nova\Metrics;

use App\Models\Ticket;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class TicketType extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // Get the ticket sold for this event by event id and group them by ticket type
        $tickets = Ticket::where('event_id', $request->resourceId)->get()->groupBy('ticket_type_id');

        // Create an array to hold the ticket types and their count
        $ticketTypes = [];

        // Loop through the tickets and add the ticket type and count to the array
        foreach ($tickets as $ticket) {
            $ticketTypes[$ticket[0]->ticket_type->name] = $ticket->count();
        }

        // Return the ticket types and their count
        return $this->result($ticketTypes);
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'ticket-type';
    }
}
