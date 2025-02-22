<?php

declare(strict_types=1);

namespace Bagwaa\Webhook;

use Bagwaa\Webhook\Listeners\StatamicEventListener;
use Statamic\Events\CollectionDeleted;
use Statamic\Events\CollectionSaved;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Events\TaxonomyDeleted;
use Statamic\Events\TaxonomySaved;
use Statamic\Events\TermDeleted;
use Statamic\Events\TermSaved;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
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

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
        'cp' => __DIR__ . '/../routes/cp.php',
        'actions' => __DIR__ . '/../routes/actions.php',
    ];

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

        Nav::extend(function ($nav) {
            $nav->content('Webhook')
                ->section('Tools')
                ->can('view bagwaa-webhook')
                ->route('bagwaa-webhook.index')
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 15-6 6m0 0-6-6m6 6V9a6 6 0 0 1 12 0v3" />
                        </svg>');
        });

        Permission::register('view bagwaa-webhook')->label('View Webhook Settings');
    }

    protected function loadHelpers(): void
    {
        require_once __DIR__ . '/helpers.php';
    }
}
