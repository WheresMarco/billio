<?php

namespace App\Listeners;

use App\Events\TicketPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Nin;

use App\Http\Controllers\TicketController;

class FinalizeTicket implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketPurchased  $event
     * @return void
     */
    public function handle(TicketPurchased $event)
    {
        // Get ticket and generate ticket code.
        $ticket = $event->ticket;
        $ticket->ticket_code = (new TicketController())->generateTicketCode();
        $ticket->status = 'unused';
        $ticket->save();

        // Get nin from database on ticket_id and mark it as utilized.
        $nin_object = Nin::where([ [ 'ticket_id', $ticket->id ]])->first();

        if ($nin_object) {
            $nin_object->update(['utilized' => true]);
        }

        // Get ticket by uuid.
        $user = $ticket->user()->first();

        $event        = $ticket->event()->first();
        $organisation = $event->organisation()->first();

        // Email the ticket.
        Mail::to($user)->send(new \App\Mail\TicketPurchased($ticket, $event, $organisation, $user));
    }
}
