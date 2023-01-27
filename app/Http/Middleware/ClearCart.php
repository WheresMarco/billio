<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ticket;

class ClearCart
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
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');

            collect($cart)->map(function ($ticket) {
                // Get ticket by id and if status is hold, delete it
                if ($ticket = Ticket::find($ticket->id)) {
                    if ($ticket->status === 'hold') {
                        $ticket->delete();
                    }
                }

                return;
            });

            session()->forget('cart');
        }

        return $next($request);
    }
}
