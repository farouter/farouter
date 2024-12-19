<?php

namespace Farouter;

use Farouter\Http\Requests\FarouterRequest;
use Illuminate\Support\ServiceProvider;

class FarouterServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Завантаження конфігурації
        $this->mergeConfigFrom(
            __DIR__.'/../config/farouter.php', 'farouter'
        );
    }

    public function boot()
    {
        // This line configures the database schema builder to use UUIDs for morphable relationships by default.
        // When creating morphable columns using the `morphs` or `uuidMorphs` methods in migrations,
        // the `morphs` method will now automatically generate a UUID column instead of an integer.
        // For example, `$table->morphs('modelable')` will create `modelable_id` as a UUID instead of a big integer.
        // This ensures consistency in database design when using UUIDs as primary keys across your application.
        $this->app['db.schema']->morphUsingUuids();

        // Публікуємо шаблон Blade
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'farouter');

        // Завантаження веб-роутів
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publishing migrations
        $this->publishes([
            // Migrations
            __DIR__.'/../database/migrations' => database_path('migrations'),

            // Operations
            __DIR__.'/../operations' => base_path('operations'),

            // Seeders
            __DIR__.'/../database/seeders' => database_path('seeders'),

            // Factories
            __DIR__.'/../database/factories' => database_path('factories'),

            // Locale
            __DIR__.'/../stubs/Locale.stub' => app_path('Farouter/Locale.php'),

            // Config
            __DIR__.'/../config/farouter.php' => config_path('farouter.php'),

            // Node
            __DIR__.'/../stubs/ConfigurationNode.stub' => app_path('Farouter/Nodes/Node.php'),

            // Resource
            __DIR__.'/../stubs/ConfigurationResource.stub' => app_path('Farouter/Resources/Resource.php'),

            // User Model
            __DIR__.'/../stubs/User.stub' => app_path('Models/User.php'),

            // Root Model with Resource and Node
            __DIR__.'/../stubs/RootModel.stub' => app_path('Models/Root.php'),
            __DIR__.'/../stubs/RootNode.stub' => app_path('Farouter/Nodes/Root.php'),
            __DIR__.'/../stubs/RootResource.stub' => app_path('Farouter/Resources/Root.php'),

            // Section Model with Resource
            __DIR__.'/../stubs/SectionModel.stub' => app_path('Models/Section.php'),
            __DIR__.'/../stubs/SectionResource.stub' => app_path('Farouter/Resources/Section.php'),

            // Laravel stubs
            __DIR__.'/../stubs/model.stub' => base_path('stubs/model.stub'),
            __DIR__.'/../stubs/migration.create.stub' => base_path('stubs/migration.create.stub'),
            __DIR__.'/../stubs/deploy-operation.stub' => base_path('stubs/deploy-operation.stub'),

            // Assets
            // __DIR__.'/../public/build' => public_path('vendor/farouter'),
        ], 'farouter-resources');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Farouter\Console\Commands\InstallCommand::class,
                \Farouter\Console\Commands\MakeResourceCommand::class,
                \Farouter\Console\Commands\MakeNodeCommand::class,
            ]);
        }

        $this->app->afterResolving(FarouterRequest::class, function ($request, $app) {
            if (! $app->bound(FarouterRequest::class)) {
                $app->instance(FarouterRequest::class, $request);
            }
        });
    }
}
