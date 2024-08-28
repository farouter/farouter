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

            $this->publishes([
                __DIR__.'/../database/migrations/create_nodes_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_nodes_table.php'),
            ], 'migrations');
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
