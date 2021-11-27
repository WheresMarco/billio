<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Ticket;
use Spatie\CalendarLinks\Link;

class TicketConfirmation extends Component
{
    public $stripe_id;
    public $tickets;

    public function mount($stripe_id, $tickets)
    {
        $this->stripe_id = $stripe_id;
        $this->tickets   = $tickets;
    }

    public function pollForFinishedTicket()
    {
        // Get transactions by stripe_id
        $transactions = Transaction::where('stripe_id', $this->stripe_id)->get();

        // Retrive tickets by ticket_id from transactions
        $tickets = $transactions->map(function ($transaction) {
            return Ticket::where('id', $transaction->ticket_id)->where('status', 'unused')->get();
        });

        // If there are tickets, set them to the tickets property
        if ($tickets->count() > 0) {
            $this->tickets = $tickets;
        }
    }

    public function render()
    {
        // Get transactions by stripe_id
        $transactions = Transaction::where('stripe_id', $this->stripe_id)->get();

        // If there are no transactions redirect to home
        if ($transactions->count() == 0) {
            return redirect()->route('home')->with('error', 'Could not find your ticket. Please contact us.');
        }

        // Retrive tickets by ticket_id from transactions
        $tickets = $transactions->map(function ($transaction) {
            return Ticket::where('id', $transaction->ticket_id)->where('status', 'unused')->get();
        });

        $calendar_link = [];

        // If there are tickets, set them to the tickets property
        if ($tickets->count() > 0) {
            $this->tickets = $tickets;

            // Get event from the first ticket
            $event = $this->tickets->first()[0]->event;

            $calendar_link = Link::create($event->name, $event->event_dates[0]->date_from, $event->event_dates[0]->date_to)
                ->description($event->excerpt)
                ->address($event->event_dates[0]->location);
        }

        return view('livewire.ticket-confirmation', [
            'tickets'        => $this->tickets,
            'calender_link' => $calendar_link,
        ]);
    }
}
