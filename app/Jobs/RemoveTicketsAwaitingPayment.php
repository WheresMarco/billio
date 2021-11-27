<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class RemoveTicketsAwaitingPayment implements ShouldQueue, ShouldBeUnique
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
        $tickets = Ticket::where('status', 'awaiting_payment')->get();

        // Loop through tickets
        foreach ($tickets as $ticket) {
            // Check if update_at is older than 1 hour
            if (strtotime($ticket->updated_at) < strtotime('-1 hour')) {
                // Delete ticket
                $ticket->delete();
            }
        }
    }
}
