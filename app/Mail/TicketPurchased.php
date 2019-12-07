<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        return $this->markdown('emails.tickets.purchased')
                    ->with([
                        'event'      => $this->event->name,
                        'orgName'    => $this->organisation->name,
                        'orgEmail'   => $this->organisation->email,
                        'orgAddress' => $this->organisation->address,
                        'name'       => $this->user->name,
                        'ticketType' => $this->ticket->ticket_type()->first()->name,
                        'ticketCode' => $this->ticket->ticket_code,
                        'logo'       => 'http://placehold.it/100x100',
                    ]);
    }
}
