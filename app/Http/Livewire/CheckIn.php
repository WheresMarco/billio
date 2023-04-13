<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class CheckIn extends Component
{
    use WithPagination;

    public $event  = 0;
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
        $tickets = Ticket::search($this->search)
            ->where('event_id', $this->event)
            ->where('findable', 1)
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
