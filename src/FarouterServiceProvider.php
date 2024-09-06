<?php

namespace Farouter;

use Farouter\Http\Middleware\HandleInertiaRequests;
use Farouter\Http\Requests\FarouterRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Route;
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

            $this->publishes([
                __DIR__.'/../public/vendor/farouter' => public_path('vendor/farouter'),
            ], 'assets');
        }

        Route::group(['middleware' => ['web', HandleInertiaRequests::class]], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'farouter');

        // $this->app->instance(FarouterRequest::class, function ($app, $request) {
        //     return new FarouterRequest($request);
        // });

        $this->app->bind(FarouterRequest::class, function (Application $app) {
            return FarouterRequest::createFrom($this->app->request);
        });

        // $this->app->afterResolving(FarouterRequest::class, function ($request, $app) {
        //     if (! $app->bound(FarouterRequest::class)) {
        //         $app->instance(FarouterRequest::class, $request);
        //     }
        // });
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
