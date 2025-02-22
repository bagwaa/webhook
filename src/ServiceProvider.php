<?php

declare(strict_types=1);

namespace Bagwaa\Webhook;

use Bagwaa\Webhook\Listeners\StatamicEventListener;
use Edalzell\Forma\Forma;
use Statamic\Events\CollectionDeleted;
use Statamic\Events\CollectionSaved;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Events\TaxonomyDeleted;
use Statamic\Events\TaxonomySaved;
use Statamic\Events\TermDeleted;
use Statamic\Events\TermSaved;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $eventsToListenFor = [
        EntrySaved::class,
        EntryDeleted::class,
        CollectionSaved::class,
        CollectionDeleted::class,
        TaxonomySaved::class,
        TaxonomyDeleted::class,
        TermSaved::class,
        TermDeleted::class,
    ];

    protected $publishAfterInstall = true; // not publishing after install

    protected $listen = [];

    public function __construct($app)
    {
        parent::__construct($app);

        $this->listen = collect($this->eventsToListenFor)
            ->mapWithKeys(function ($event) {
                return [$event => [StatamicEventListener::class]];
            })
            ->toArray();
    }

    public function register(): void
    {
        $this->loadHelpers();
    }

    public function bootAddon(): void
    {
        parent::bootAddon();

        Forma::add('bagwaa/webhook');

        $this->publishes([
            __DIR__ . '/../config/webhook.php' => config_path('webhook.php'), // can I not put this in the statamix subfolder in config?
        ], 'bagwaa/webhook');
    }

    protected function loadHelpers(): void
    {
        require_once __DIR__ . '/helpers.php';
    }
}
