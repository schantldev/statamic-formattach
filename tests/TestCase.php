<?php

namespace SchantlDev\Statamic\FormAttach\Tests;

use SchantlDev\Statamic\FormAttach\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
