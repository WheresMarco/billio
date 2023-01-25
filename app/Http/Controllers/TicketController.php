<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function ticketsSold($eventID, $ticketTypeID)
    {
        $tickets     = Ticket::where([['event_id', $eventID], ['ticket_type_id', $ticketTypeID]])->get();
        $ticketsSold = $tickets->count();

        return $ticketsSold;
    }

    /**
     * Generate a ticket code.
     *
     * @since    1.0.0
     *
     * @param  int  $length - The length of the ticket code.
     * @return   string
     */
    public function generateTicketCode(int $length = 6)
    {
        $max_random_number = 3000000000 === 2147483647 ? (float) '4294967295' : 4294967295; // 4294967295 = 0xffffffff

        // Create ticket code that is not taken.
        $ticket_code = null;

        while (null === $ticket_code) {
            $temp_ticket_code = dechex(rand($length / 2 + ($length % 2 > 0), $max_random_number));

            // Check if taken, if not assign to $uuid.
            $ticket = Ticket::where('ticket_code', $temp_ticket_code)->first();
            if (!$ticket) {
                $ticket_code = $temp_ticket_code;
            }
        }

        return $ticket_code;
    }
}
