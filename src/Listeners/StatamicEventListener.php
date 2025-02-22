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
        $eventType = get_class($event);

        if ($eventType === EntrySaved::class && !config('webhook.webhook_entry_saved_event')) {
            return;
        }

        if ($eventType === EntryDeleted::class && !config('webhook.webhook_entry_deleted_event')) {
            return;
        }

        if ($eventType === CollectionSaved::class && !config('webhook.webhook_collection_saved_event')) {
            return;
        }

        if ($eventType === CollectionDeleted::class && !config('webhook.webhook_collection_deleted_event')) {
            return;
        }

        if ($eventType === TaxonomySaved::class && !config('webhook.webhook_taxonomy_saved_event')) {
            return;
        }

        if ($eventType === TaxonomyDeleted::class && !config('webhook.webhook_taxonomy_deleted_event')) {
            return;
        }

        if ($eventType === TermSaved::class && !config('webhook.webhook_term_saved_event')) {
            return;
        }

        if ($eventType === TermDeleted::class && !config('webhook.webhook_term_deleted_event')) {
            return;
        }

        // Maybe we want to transform/obfuscate some of the event
        // data before sending it to the webhook?

        Http::post($webhookUrl, [
            'entry' => $event,
        ]);
    }
}
