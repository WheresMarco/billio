<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class CheckInController extends Controller
{
    public function checkIn(Request $request)
    {
        $ticketCode   = $request->ticket_code;
        $ticketStatus = $request->ticket_status;
        $ticket  = Ticket::where('ticket_code', $ticketCode)->first();

        if (null === $ticket) {
            return 'Could not find ticket.';
        }

        // Update ticket status.
        $ticket->status = $ticketStatus;
        $ticket->save();

        return [
            'id' => $ticket->UUID,
            'status' => $ticket->status
        ];
    }

    public function search(Request $request)
    {
        $ticketCode = $request->ticket_code;

        // If no ticket code
        if (null === $ticketCode) {
            return 'No ticket code provided.';
        }

        // Get ticket by ticket code
        $ticket = Ticket::where('ticket_code', $ticketCode)->first();

        if (! $ticket) {
            return 'Could not find ticket.';
        }

        // Get modifers
        $modifiers = [];
        $modifiers = array_map(
            function ($modifier) {
                    return $modifier['name'];
            },
            $ticket->modifiers()->get()->toArray()
        );

        return [
            'id'         => $ticket->id,
            'name'       => $ticket->user()->first()->name,
            'email'      => $ticket->user()->first()->email,
            'code'       => $ticket->ticket_code,
            'ticketType' => $ticket->ticket_type()->first()->name,
            'modifiers'  => implode(', ', $modifiers),
        ];
    }
}
