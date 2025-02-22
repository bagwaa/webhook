<?php

declare(strict_types=1);

use Bagwaa\Webhook\Listeners\StatamicEventListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Statamic\Entries\Entry;
use Statamic\Events\CollectionDeleted;
use Statamic\Events\CollectionSaved;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Events\TaxonomyDeleted;
use Statamic\Events\TaxonomySaved;
use Statamic\Events\TermSaved;
use Statamic\Facades\Collection;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\Term;

it('is listening for the EventSaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(EntrySaved::class, StatamicEventListener::class);
});

it('sends a webhook when an entry is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_entry_saved_event', true);

    Http::fake();

    $entry = Entry::make()
        ->id('test-entry')
        ->slug('test-entry')
        ->collection(Collection::make('blog'))
        ->data(['title' => 'Test Entry']);

    // act
    EntrySaved::dispatch($entry);

    // assert
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('does not send a webhook when an entry is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_entry_saved_event', false);

    Http::fake();

    $entry = Entry::make()
        ->id('test-entry')
        ->slug('test-entry')
        ->collection(Collection::make('blog'))
        ->data(['title' => 'Test Entry']);

    // act
    EntrySaved::dispatch($entry);

    // assert
    Http::assertNotSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('is listening for the EntryDeleted event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(EntryDeleted::class, StatamicEventListener::class);
});

it('sends a webhook when an entry is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_entry_deleted_event', true);

    Http::fake();

    $entry = Entry::make()
        ->id('test-entry')
        ->slug('test-entry')
        ->collection(Collection::make('blog'))
        ->data(['title' => 'Test Entry']);

    // act
    EntryDeleted::dispatch($entry);

    // assert
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('does not send a webhook when an entry is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_entry_deleted_event', false);

    Http::fake();

    $entry = Entry::make()
        ->id('test-entry')
        ->slug('test-entry')
        ->collection(Collection::make('blog'))
        ->data(['title' => 'Test Entry']);

    // act
    EntryDeleted::dispatch($entry);

    // assert
    Http::assertNotSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('is listening for the CollectionSaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(CollectionSaved::class, StatamicEventListener::class);
});

it('sends a webhook when a collection is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_collection_saved_event', true);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionSaved::dispatch($collection);

    // assert
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('does not send a webhook when a collection is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_collection_saved_event', false);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionSaved::dispatch($collection);

    // assert
    Http::assertNotSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('is listening for the CollectionDeleted event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(CollectionDeleted::class, StatamicEventListener::class);
});

it('sends a webhook when a collection is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_collection_deleted_event', true);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionDeleted::dispatch($collection);

    // assert
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('does not send a webhook when a collection is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_collection_deleted_event', false);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionDeleted::dispatch($collection);

    // assert
    Http::assertNotSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('is listening for the TaxonomySaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(TaxonomySaved::class, StatamicEventListener::class);
});

it('sends a webhook when a taxonomy is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_taxonomy_saved_event', true);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomySaved::dispatch($taxonomy);

    // assert
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('does not send a webhook when a taxonomy is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_taxonomy_saved_event', false);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomySaved::dispatch($taxonomy);

    // assert
    Http::assertNotSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('is listening for the TaxonomyDeleted event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(TaxonomyDeleted::class, StatamicEventListener::class);
});

it('sends a webhook when a taxonomy is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_taxonomy_deleted_event', true);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomyDeleted::dispatch($taxonomy);

    // assert
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('does not send a webhook when a taxonomy is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_taxonomy_deleted_event', false);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomyDeleted::dispatch($taxonomy);

    // assert
    Http::assertNotSent(function ($request) {
        return $request->url() === 'https://example.com/webhook';
    });
});

it('is listening for the TermSaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(TermSaved::class, StatamicEventListener::class);
});

// Add test for when a term is saved and deleted
