<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class CheckInController extends Controller
{
    public function checkIn( Request $request )
    {
        $ticketCode   = $request->ticket_code;
        $ticketStatus = $request->ticket_status;
        $ticket  = Ticket::where( 'ticket_code', $ticketCode )->first();

        if ( null === $ticket )
        {
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
}
