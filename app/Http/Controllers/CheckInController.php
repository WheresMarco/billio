<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class CheckInController extends Controller
{
    public function getAllTickets()
    {
        // Get all tickets with user information
        $tickets = Ticket::with('user', 'nin')->get();

        return $tickets;
    }

    public function checkIn(Request $request)
    {
        $uuid         = $request->uuid;
        $ticketStatus = $request->status;
        $ticket       = Ticket::where('uuid', $uuid)->first();

        if (null === $ticket) {
            return response()->json(['message' => 'Could not find ticket'], 404);
        }

        // Check that we have a status
        if (null === $ticketStatus) {
            return response()->json(['message' => 'No status provided'], 400);
        }

        // Update ticket status.
        $ticket->status = $ticketStatus;
        $ticket->save();

        // Get modifers
        $modifiers = [];
        $modifiers = array_map(
            function ($modifier) {
                    return $modifier['name'];
            },
            $ticket->modifiers()->get()->toArray()
        );

        return [
            'uuid'       => $ticket->uuid,
            'name'       => $ticket->user()->first()->name,
            'email'      => $ticket->user()->first()->email,
            'code'       => $ticket->ticket_code,
            'type'       => $ticket->ticket_type()->first()->name,
            'modifiers'  => implode(', ', $modifiers),
            'status'     => $ticket->status,
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
            return response()->json(['message' => 'Could not find ticket'], 404);
        }

        // Get modifers
        $modifiers = [];
        $modifiers = array_map(
            function ($modifier) {
                    return $modifier['name'];
            },
            $ticket->modifiers()->get()->toArray()
        );

        return response()->json([
            'uuid'       => $ticket->uuid,
            'name'       => $ticket->user()->first()->name,
            'email'      => $ticket->user()->first()->email,
            'code'       => $ticket->ticket_code,
            'type'       => $ticket->ticket_type()->first()->name,
            'modifiers'  => implode(', ', $modifiers),
            'status'     => $ticket->status,
        ], 200);
    }
}
