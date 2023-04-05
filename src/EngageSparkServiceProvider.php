<?php

namespace LBHurtado\EngageSpark;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\ChannelManager;

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
            ], 'engagespark-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'engagespark');

        $this->app->singleton(EngageSpark::class, function ($app) {
            return new EngageSpark(new HttpClient([
                // 'timeout'         => 5,
                // 'connect_timeout' => 5,
            ]));
        });
        
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('engage_spark', function ($app) {
                return new EngageSparkChannel($app->make(EngageSpark::class));
            });
        });
    }
}
