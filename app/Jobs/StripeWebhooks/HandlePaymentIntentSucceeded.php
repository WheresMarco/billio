<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;

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
        $payload = $this->webhookCall->payload;
        $stripe_object = $payload['data']['object'];
        $tickets = isset($stripe_object['metadata']['tickets']) ? explode(',', $stripe_object['metadata']['tickets']) ?? [] : [];
        $donation_id = isset($stripe_object['metadata']['donation_id']) ? $stripe_object['metadata']['donation_id'] : null;

        if ($donation_id) {
            $donation = \App\Models\Donation::where('id', $donation_id)->first();

            if ($donation) {
                // Check correct status for donation - awaiting_payment.
                if ('awaiting_payment' !== $donation->status) {
                    Log::error('Donation not awaiting payment '.print_r($donation->id, true));

                    return;
                }

                $donation->status = 'paid';
                $donation->save();
            }

            return;
        }

        foreach ($tickets as $ticket_id) {
            $ticket = Ticket::where('uuid', $ticket_id)->first();

            if ($ticket) {
                // Check correct status for ticket - awaiting_payment.
                if ('awaiting_payment' !== $ticket->status) {
                    Log::error('Ticket not awaiting payment '.print_r($ticket->id, true));

                    return;
                }

                // Send of event to finalize ticket.
                event(new \App\Events\TicketPurchased($ticket));
            }
        }
    }
}
