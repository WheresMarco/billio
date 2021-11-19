<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

use App\Ticket;
use App\Event;
use App\Organisation;
use App\User;

class TicketPurchased extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticket;
    protected $event;
    protected $organisation;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, Event $event, Organisation $organisation, User $user)
    {
        $this->ticket       = $ticket;
        $this->event        = $event;
        $this->organisation = $organisation;
        $this->user         = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hi@billio.app')
                    ->subject($this->event->name . ': ' . $this->ticket->ticket_type()->first()->name . ' [' . $this->ticket->ticket_code . ']')
                    ->with([
                        'event'      => $this->event->name,
                        'orgName'    => $this->organisation->title,
                        'orgEmail'   => $this->organisation->email,
                        'orgAddress' => $this->organisation->address,
                        'name'       => $this->user->name,
                        'ticketType' => $this->ticket->ticket_type()->first()->name,
                        'ticketCode' => $this->ticket->ticket_code,
                        'modifiers'  => $this->ticket->modifiers()->get(),
                    ])
                    ->markdown('emails.tickets.purchased');
    }
}
