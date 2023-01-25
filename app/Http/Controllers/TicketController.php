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
     * Resend a ticket to user.
     *
     * @param  Ticket  $ticket
     * @return void
     */
    public function resendTicket(Ticket $ticket)
    {
        $user = $ticket->user()->first();
        $event = $ticket->event()->first();
        $organisation = $event->organisation()->first();

        // Email the ticket.
        Mail::to($user)->send(new \App\Mail\TicketPurchased($ticket, $event, $organisation, $user));
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

    /**
     * Generates a unique ID
     *
     * @since    1.0.0
     *
     * @return   string
     */
    public function genTicketUUID()
    {
        $uuid = null;

        while (null === $uuid) {
            $temp_uuid = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                rand(0, 0xFFFF),
                rand(0, 0xFFFF), // 32 bits for "time_low"
                rand(0, 0xFFFF), // 16 bits for "time_mid"
                rand(0, 0x0FFF) | 0x4000, // 16 bits for "time_hi_and_version", four most significant bits holds version number 4
                rand(0, 0x3FFF) | 0x8000, // 16 bits, 8 bits for "clk_seq_hi_res", 8 bits for "clk_seq_low", two most significant bits holds zero and one for variant DCE1.1
                rand(0, 0xFFFF),
                rand(0, 0xFFFF),
                rand(0, 0xFFFF) // 48 bits for "node"
            );

            // Check if taken, if not assign to $uuid.
            $ticket = Ticket::where('uuid', $temp_uuid)->first();
            if (!$ticket) {
                $uuid = $temp_uuid;
            }
        }

        return $uuid;
    }
}
