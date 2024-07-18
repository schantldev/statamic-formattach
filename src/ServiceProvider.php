<?php

namespace SchantlDev\Statamic\FormAttach;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'web' => __DIR__.'/../routes/web.php',
    ];

    public function bootAddon()
    {
        // boot config
        $this->mergeConfigFrom(__DIR__.'/../config/statamic-formattach.php', 'statamic-formattach');

        $this->publishes([
            __DIR__.'/../config/statamic-formattach.php' => config_path('statamic-formattach.php'),
        ], 'statamic-formattach-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/statamic-formattach'),
        ], 'statamic-formattach-views');

        // publish views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-formattach');
    }
}
