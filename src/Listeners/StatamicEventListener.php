<?php

declare(strict_types=1);

namespace Bagwaa\Webhook\Listeners;

use Illuminate\Support\Facades\Http;
use Statamic\Events\CollectionDeleted;
use Statamic\Events\CollectionSaved;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Events\Event;
use Statamic\Events\TaxonomyDeleted;
use Statamic\Events\TaxonomySaved;
use Statamic\Events\TermDeleted;
use Statamic\Events\TermSaved;

class StatamicEventListener
{
    public function handle(Event $event): void
    {
        $webhookUrl = config('webhook.webhook_url');

        if ($event::class === EntrySaved::class && config('webhook.webhook_entry_saved_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === EntryDeleted::class && config('webhook.webhook_entry_deleted_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === CollectionSaved::class && config('webhook.webhook_collection_saved_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === CollectionDeleted::class && config('webhook.webhook_collection_deleted_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === TaxonomySaved::class && config('webhook.webhook_taxonomy_saved_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === TaxonomyDeleted::class && config('webhook.webhook_taxonomy_deleted_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === TermSaved::class && config('webhook.webhook_term_saved_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        if ($event::class === TermDeleted::class && config('webhook.webhook_term_deleted_event')) {
            $this->sendWebhook($webhookUrl, $event);
        }

        // Maybe we want to transform/obfuscate some of the event
        // data before sending it to the webhook?
    }

    private function sendWebhook(string $webhookUrl, Event $event): void
    {
        Http::post($webhookUrl, [
            'entry' => $event,
        ]);
    }
}
