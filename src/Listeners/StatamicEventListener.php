<?php

declare(strict_types=1);

namespace Bagwaa\Webhook\Listeners;

use Illuminate\Support\Facades\Http;
use Statamic\Events\Event;

class StatamicEventListener
{
    public function handle(Event $event): void
    {
        $webhookUrl = config('webhook.webhook_url');

        // Maybe we want to transform/obfuscate some of the event
        // data before sending it to the webhook?

        Http::post($webhookUrl, [
            'entry' => $event,
        ]);
    }
}
