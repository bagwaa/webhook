<?php

declare(strict_types=1);

namespace Bagwaa\Webhook\Listeners;

use Illuminate\Support\Facades\Http;
use Statamic\Events\Event;

class StatamicEventListener
{
    public function handle(Event $event): void
    {
        $webhookUrl = config('webhook.webhook_url', []);

        foreach (config('webhook.events') as $eventConfig) {
            if ($event::class === $eventConfig['class'] && $eventConfig['enabled']) {
                $this->sendWebhook($webhookUrl, $event);
            }
        }

        // Maybe we want to transform/obfuscate some of the event
        // data before sending it to the webhook?
    }

    private function sendWebhook(string $webhookUrl, Event $event): void
    {
        $headerKey = config('webhook.webhook_auth_header_key');
        $headerValue = config('webhook.webhook_auth_header_value');

        if ($headerKey && $headerValue) {
            Http::withHeader($headerKey, $headerValue)
                ->post($webhookUrl, [
                    'entry' => $event,
                ]);

            return;
        }

        Http::post($webhookUrl, [
            'entry' => $event,
        ]);
    }
}
