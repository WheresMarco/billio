<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckForAccessCode
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
        if ($request->has('access_code')) {
            // Get the event from the slug
            $event = \App\Models\Event::where('slug', $request->route('eventSlug'))->first();

            // Get the access code
            $accessCode = \App\Models\AccessCode::where('code', $request->input('access_code'))
                ->where('event_id', $event->id)
                ->first();

            // Check if the date is valid
            if ($accessCode && $accessCode->valid_until && $accessCode->valid_until->isPast()) {
                $accessCode = null;
            }

            // Check if limit is reached
            if ($accessCode && $accessCode->limit && $accessCode->transactions()->count() >= $accessCode->limit) {
                $accessCode = null;
            }

            if ($accessCode) {
                $request->session()->put('access_code', $accessCode->code);
                $request->session()->put('access_code_event', $event->name);
                $request->session()->put('access_code_event_id', $event->id);
            }
        }

        return $next($request);
    }
}
