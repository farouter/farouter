<?php

namespace Farouter;

use Illuminate\Support\ServiceProvider;

class FarouterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('farouter.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'farouter');

        $this->commands([
            Console\BaseResourceCommand::class,
            Console\ResourceCommand::class,
        ]);
    }
}
