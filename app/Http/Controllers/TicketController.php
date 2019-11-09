<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{
    /**
     * Get ticket by id.
     *
     * @return void
     */
    public function ticket( Request $request, $id )
    {
        return 'not implemented';
    }

    /**
     * Get a users tickets.
     *
     * @return void
     */
    public function user_tickets( Request $request, int $id )
    {
        return 'not implemented';
    }

    /**
     * Create ticket.
     *
     * @return void
     */
    public function create()
    {
        return 'not implemented';
    }

    /**
     * Update ticket.
     *
     * @return void
     */
    public function update( Request $request, int $id )
    {
        return 'not implemented';
    }

    /**
     * Delete ticket.
     *
     * @return void
     */
    public function delete( Request $request, int $id )
    {
        return 'not implemented';
    }
}
