<?php

namespace Bagwaa\Webhook\Tests;

use Bagwaa\Webhook\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
