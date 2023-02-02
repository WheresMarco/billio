<?php

namespace App\Nova\Metrics;

use App\Models\Ticket;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TicketsSold extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // Get the number of tickets sold for this event by event_id
        $ticketsSold = Ticket::where('event_id', $request->resourceId)->count();

        // Return the number of tickets sold
        return $this->result($ticketsSold);
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
        return 'tickets-sold';
    }
}
