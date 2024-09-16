<?php

namespace DK\QuickCms;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use DK\QuickCms\Console\Commands\InstallAdminLte;

class QuickCmsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallAdminLte::class
            ]);
        }

        // Publish package migrations
        $this->publishes([
            __DIR__.'/Migrations' => database_path('migrations'),
        ], 'migrations');

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/quick-cms'),
        ], 'views');

        // Load views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'quick-cms');
        // Register routes
        $this->loadRoutesFrom(__DIR__.'/routes/admin.php');

        $this->publishes([
            __DIR__.'/../config/quick-cms.php' => config_path('quick-cms.php'),
        ], 'config');
    }
}
