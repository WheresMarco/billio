<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class CheckIn extends Component
{
    use WithPagination;

    public $event  = null;
    public $search = '';

    public function changeStatus($id, $status)
    {
        $ticket                = Ticket::find($id);
        $ticket->status        = $status;
        $ticket->checked_in_at = now();
        $ticket->save();
    }

    public function render()
    {
        // Get tickets by ticket code or user name or user email based on event
        $tickets = Ticket::where('event_id', $this->event)
            ->where('status', '!=', 'awaiting_payment')
            ->where('status', '!=', 'hold')
            ->where(function ($query) {
                $query->where('ticket_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate(5);

        return view(
            'livewire.check-in',
            [
                'events' => Event::all(),
                'tickets' => $tickets,
            ]
        );
    }
}
