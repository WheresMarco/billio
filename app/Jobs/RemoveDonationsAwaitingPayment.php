<?php

namespace App\Jobs;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveDonationsAwaitingPayment implements ShouldQueue, ShouldBeUnique
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
        $donations = Donation::where('status', 'awaiting_payment')->get();

        // Loop through donations
        foreach ($donations as $donation) {
            // Check if update_at is older than 1 hour
            if (strtotime($donation->updated_at) < strtotime('-1 hour')) {
                // Delete donation
                $donation->delete();
            }
        }
    }
}
