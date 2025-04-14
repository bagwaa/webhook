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
use Statamic\Events\UserCreated;
use Statamic\Events\UserDeleted;
use Statamic\Events\UserSaved;
use Statamic\Facades\Collection;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\User;

it('is listening for the EventSaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(EntrySaved::class, StatamicEventListener::class);
});

it('sends a webhook when an entry is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.entry_saved.enabled', true);

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
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof EntrySaved;
    });
});

it('can send a custom header with the webhook', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.webhook_auth_header_key', 'X-Custom-Header');
    config()->set('webhook.webhook_auth_header_value', 'Custom Value');
    config()->set('webhook.events.entry_saved.enabled', true);

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
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof EntrySaved
            && $request->hasHeader('X-Custom-Header', 'Custom Value');
    });
});

it('does not send a webhook when an entry is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.entry_saved.enabled', false);

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
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof EntrySaved;
    });
});

it('is listening for the EntryDeleted event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(EntryDeleted::class, StatamicEventListener::class);
});

it('sends a webhook when an entry is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.entry_deleted.enabled', true);

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
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof EntryDeleted;
    });
});

it('does not send a webhook when an entry is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.entry_deleted.enabled', false);

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
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof EntryDeleted;
    });
});

it('is listening for the CollectionSaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(CollectionSaved::class, StatamicEventListener::class);
});

it('sends a webhook when a collection is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.collection_saved.enabled', true);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionSaved::dispatch($collection);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof CollectionSaved;
    });
});

it('does not send a webhook when a collection is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.collection_saved.enabled', false);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionSaved::dispatch($collection);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof CollectionSaved;
    });
});

it('is listening for the CollectionDeleted event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(CollectionDeleted::class, StatamicEventListener::class);
});

it('sends a webhook when a collection is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.collection_deleted.enabled', true);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionDeleted::dispatch($collection);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof CollectionDeleted;
    });
});

it('does not send a webhook when a collection is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.collection_deleted.enabled', false);

    Http::fake();

    $collection = Collection::make('blog');

    // act
    CollectionDeleted::dispatch($collection);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof CollectionDeleted;
    });
});

it('is listening for the TaxonomySaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(TaxonomySaved::class, StatamicEventListener::class);
});

it('sends a webhook when a taxonomy is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.taxonomy_saved.enabled', true);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomySaved::dispatch($taxonomy);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof TaxonomySaved;
    });
});

it('does not send a webhook when a taxonomy is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.taxonomy_saved.enabled', false);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomySaved::dispatch($taxonomy);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof TaxonomySaved;
    });
});

it('is listening for the TaxonomyDeleted event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(TaxonomyDeleted::class, StatamicEventListener::class);
});

it('sends a webhook when a taxonomy is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.taxonomy_deleted.enabled', true);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomyDeleted::dispatch($taxonomy);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof TaxonomyDeleted;
    });
});

it('does not send a webhook when a taxonomy is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.taxonomy_deleted.enabled', false);

    Http::fake();

    $taxonomy = Taxonomy::make('tags');

    // act
    TaxonomyDeleted::dispatch($taxonomy);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof TaxonomyDeleted;
    });
});

it('is listening for the TermSaved event and is handled by StatamicEventListener', function () {
    Event::fake();

    Event::assertListening(TermSaved::class, StatamicEventListener::class);
});

it('sends a webhook when a user is created', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.user_created.enabled', true);

    Http::fake();

    $user = User::make()
        ->email('test@example.com')
        ->set('name', 'Test User')
        ->save();

    // act
    UserCreated::dispatch($user);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof UserCreated;
    });
});

it('does not send a webhook when a user is created if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.user_created.enabled', false);

    Http::fake();

    $user = User::make()
        ->email('test@example.com')
        ->set('name', 'Test User')
        ->save();

    // act
    UserCreated::dispatch($user);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof UserCreated;
    });
});

it('sends a webhook when a user is deleted', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.user_deleted.enabled', true);

    Http::fake();

    $user = User::make()
        ->email('test@example.com')
        ->set('name', 'Test User')
        ->save();

    // act
    UserDeleted::dispatch($user);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof UserDeleted;
    });
});

it('does not send a webhook when a user is deleted if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.user_deleted.enabled', false);

    Http::fake();

    $user = User::make()
        ->email('test@example.com')
        ->set('name', 'Test User')
        ->save();

    // act
    UserDeleted::dispatch($user);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof UserDeleted;
    });
});

it('sends a webhook when a user is saved', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.user_saved.enabled', true);

    Http::fake();

    $user = User::make()
        ->email('test@example.com')
        ->set('name', 'Test User')
        ->save();

    // act
    UserSaved::dispatch($user);

    // assert
    Http::assertSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof UserSaved;
    });
});

it('does not send a webhook when a user is saved if the config is set to false', function () {
    // arrange
    config()->set('webhook.webhook_url', 'https://example.com/webhook');
    config()->set('webhook.events.user_saved.enabled', false);

    Http::fake();

    $user = User::make()
        ->email('test@example.com')
        ->set('name', 'Test User')
        ->save();

    // act
    UserSaved::dispatch($user);

    // assert
    Http::assertNotSent(function ($request) {
        $event = $request->data()['entry'];

        return $request->url() === 'https://example.com/webhook'
            && $event instanceof UserSaved;
    });
});
