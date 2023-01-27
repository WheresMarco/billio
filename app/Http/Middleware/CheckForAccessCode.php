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

            // Check if the access code is valid
            // TODO: Check limits and dates
            $accessCode = \App\Models\AccessCode::where('code', $request->input('access_code'))
                ->where('event_id', $event->id)
                ->first();

            if ($accessCode) {
                $request->session()->put('access_code', $accessCode->code);
                $request->session()->put('access_code_event', $event->name);
                $request->session()->put('access_code_event_id', $event->id);
            }
        }

        return $next($request);
    }
}
