<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;

class HandleFailedCharge implements ShouldQueue
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
        $tickets = explode(',', $stripe_object['metadata']['tickets']) ?? [];

        foreach ($tickets as $ticket_id) {
            $ticket = Ticket::where('uuid', $ticket_id)->first();

            if ($ticket) {
                // Check correct status for ticket - awaiting_payment.
                if ('awaiting_payment' !== $ticket->status) {
                    Log::error('Ticket not awaiting payment '.print_r($ticket->id, true));

                    return;
                }

                $ticket->delete();

                // TODO Send of email notifing user of failed payment.
            }
        }
    }
}
