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
        return view(
            'livewire.check-in',
            [
                'events' => Event::all(),
                'tickets' => Ticket::where('event_id', $this->event)->search('ticket_code', $this->search)->paginate(10),
            ]
        );
    }
}
