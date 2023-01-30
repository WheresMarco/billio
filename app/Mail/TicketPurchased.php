<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Organisation;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        $this->ticket = $ticket;
        $this->event = $event;
        $this->organisation = $organisation;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hi@billio.app', 'Billio')
            ->subject($this->event->name . ': ' . $this->ticket->ticket_type()->first()->name . ' [' . $this->ticket->ticket_code . ']')
            ->with([
                'event' => $this->event->name,
                'occurrence' =>  $this->ticket->occurrence ? $this->ticket->occurrence->date_from->format('Y-m-d H:i') . ' - ' . $this->ticket->occurrence->date_to->format('Y-m-d H:i') . '(' . $this->ticket->occurrence->location . ')' : '',
                'orgName' => $this->organisation->title,
                'orgEmail' => $this->organisation->email,
                'orgAddress' => $this->organisation->address,
                'name' => $this->user->name,
                'ticketType' => $this->ticket->ticket_type()->first()->name,
                'ticketCode' => $this->ticket->ticket_code,
                'modifiers' => $this->ticket->modifiers()->get(),
            ])
            ->markdown('emails.tickets.purchased');
    }
}
