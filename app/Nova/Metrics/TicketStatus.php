<?php

namespace App\Nova\Metrics;

use App\Models\Ticket;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class TicketStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $tickets = Ticket::where('event_id', $request->resourceId)->get()->groupBy('status');

        // Create an array to hold the ticket types and their count
        $ticketStatus = [];

        // Loop through the tickets and add the ticket type and count to the array
        foreach ($tickets as $ticket) {
            $ticketStatus[$ticket[0]->status] = $ticket->count();
        }

        return $this->result($ticketStatus);
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
        return 'ticket-status';
    }
}
