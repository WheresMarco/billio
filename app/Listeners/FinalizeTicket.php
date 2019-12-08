<?php

namespace App\Listeners;

use App\Events\TicketPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\TicketController;
use QrCode;

class FinalizeTicket
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
        $ticket->ticket_code = ( new TicketController() )->generateTicketCode();
        $ticket->status = 'unused';
        $ticket->save();

        // Generate QR-code
        $image = QrCode::format('png')
            ->size(400)->errorCorrection('H')
            ->margin(0)
            ->generate($ticket->ticket_code);
        $qr_path = 'public/qr/' . $ticket->ticket_code . '.png';

        Storage::put($qr_path, $image);
        $url  = Storage::url($qr_path);

        // Get ticket by uuid.
        $user = $ticket->user()->first();

        $event        = $ticket->event()->first();
        $organisation = $event->organisation()->first();

        // Email the ticket.
        Mail::to($user)->send(new \App\Mail\TicketPurchased($ticket, $event, $organisation, $user));
    }
}
