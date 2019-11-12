<?php

namespace App\Jobs\StripeWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;

class HandleChargeableSource implements ShouldQueue
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
        // you can access the payload of the webhook call with `$this->webhookCall->payload`


        // TODO Get ticket by source

        // TODO Check correct status for ticket - awaiting_payment

        // TODO Make charge

        // TODO Add to transactions

        // TODO Update ticket status.

        // TODO Generate QR-code

        // TODO Event ticket_charged or something - send ticket email, ping frontend
    }
}
