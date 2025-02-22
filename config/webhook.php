<?php

declare(strict_types=1);

return [
    'webhook_url' => 'https://example.com/webhook',

    'events' => [
        'entry_saved' => [
            'enabled' => true,
            'class' => \Statamic\Events\EntrySaved::class,
        ],
        'entry_deleted' => [
            'enabled' => true,
            'class' => \Statamic\Events\EntryDeleted::class,
        ],
        'collection_saved' => [
            'enabled' => true,
            'class' => \Statamic\Events\CollectionSaved::class,
        ],
        'collection_deleted' => [
            'enabled' => true,
            'class' => \Statamic\Events\CollectionDeleted::class,
        ],
        'taxonomy_saved' => [
            'enabled' => true,
            'class' => \Statamic\Events\TaxonomySaved::class,
        ],
        'taxonomy_deleted' => [
            'enabled' => true,
            'class' => \Statamic\Events\TaxonomyDeleted::class,
        ],
        'term_saved' => [
            'enabled' => true,
            'class' => \Statamic\Events\TermSaved::class,
        ],
        'term_deleted' => [
            'enabled' => true,
            'class' => \Statamic\Events\TermDeleted::class,
        ],
    ],

    'webhook_auth_header_key' => 'X-Webhook',
    'webhook_auth_header_value' => 'Foo',
];
