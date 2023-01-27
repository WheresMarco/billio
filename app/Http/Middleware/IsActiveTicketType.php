<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsActiveTicketType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the event from the slug
        $event = \App\Models\Event::where('slug', $request->route('eventSlug'))->first();

        // Get the ticket type from the slug
        $ticketType = \App\Models\TicketType::where('slug', $request->route('ticketType'))->first();

        // If no ticket type is found, redirect to the event page
        if (!$ticketType) {
            return redirect()->route('event', ['eventSlug' => $event->slug]);
        }

        // Check if the ticket type is active or if you have an valid access code
        if (!$ticketType->active && !$request->session()->has('access_code')) {
            // Check if access code is valid for the event
            // TODO: Check limits and dates
            $accessCode = \App\Models\AccessCode::where('code', $request->session()->get('access_code'))
                ->where('event_id', $event->id)
                ->first();

            if ($accessCode) {
                return $next($request);
            }

            return redirect()->route('event', ['eventSlug' => $event->slug]);
        }

        return $next($request);
    }
}
