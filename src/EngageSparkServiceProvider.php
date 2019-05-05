<?php

namespace LBHurtado\EngageSpark;

use Illuminate\Support\ServiceProvider;

class EngageSparkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('engagespark.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'engagespark');

        $this->app->singleton(EngageSpark::class, function ($app) {
            return new EngageSpark($app['config']['engagespark']);
        });
    }
}
