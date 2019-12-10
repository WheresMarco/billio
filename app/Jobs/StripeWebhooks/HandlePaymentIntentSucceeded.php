<?php

namespace App\Jobs\StripeWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Log;

use App\Ticket;

class HandlePaymentIntentSucceeded implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        $payload       = $this->webhookCall->payload;
        $stripe_object = $payload['data']['object'];
        $source_id     = $stripe_object['id'];

        // Get ticket by uuid.
        $ticket = Ticket::where( 'uuid', $stripe_object['metadata']['ticket_id'] )->first();

        // Check correct status for ticket - awaiting_payment.
        if ( 'awaiting_payment' !== $ticket->status )
        {
            Log::error('Ticket not awaiting payment ' . print_r( $ticket->id, true ));
            return;
        }

        // Update ticket status.
        $ticket->status = 'paid';
        $ticket->save();

        // Send of event to finilize ticket.
        event(new \App\Events\TicketPurchased($ticket));
    }
}
