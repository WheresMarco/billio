<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Models\Transaction;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

class TicketConfirmation extends Component
{
    public $stripe_id;

    public $tickets;

    public function mount($stripe_id, $tickets)
    {
        $this->stripe_id = $stripe_id;
        $this->tickets = $tickets;
    }

    public function pollForFinishedTicket()
    {
        // Get transactions by stripe_id
        $transactions = Transaction::where('stripe_id', $this->stripe_id)->get();

        $tickets = [];
        foreach ($transactions as $transaction) {
            $ticket = $transaction->ticket;

            if ($ticket->status == 'unused') {
                $tickets[] = $ticket;
            }
        }

        // If there are tickets, set them to the tickets property
        if (count($tickets) > 0) {
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

        $tickets = [];

        foreach ($transactions as $transaction) {
            $ticket = $transaction->ticket;

            if ($ticket->status == 'unused') {
                $tickets[] = $ticket;
            }
        }

        $calendar_link = [];

        // If there are tickets, set them to the tickets property
        if (count($tickets) > 0) {
            $this->tickets = $tickets;

            // Get event from the first ticket
            $event = $tickets[0]->event;

            $calendar_link = Link::create($event->name, $event->date_from, $event->date_to)
                ->description($event->excerpt)
                ->address($event->event_dates[0]->location);
        }

        return view('livewire.ticket-confirmation', [
            'tickets' => $this->tickets,
            'calender_link' => $calendar_link,
        ]);
    }
}
