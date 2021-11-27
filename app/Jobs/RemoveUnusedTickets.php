<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class RemoveUnusedTickets implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all tickets with status hold or awaiting_payment
        $tickets = Ticket::where('status', 'hold')->get();

        // Loop through tickets
        foreach ($tickets as $ticket) {
            // Check if update_at is older than 10 minutes
            if (strtotime($ticket->updated_at) < strtotime('-10 minutes')) {
                // Delete ticket
                $ticket->delete();
            }
        }
    }
}
