<?php

namespace Kangangga\Starsender;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\PendingRequest;

class StarsenderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!config('starsender.enabled')) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/starsender.php' => config_path('starsender.php'),
            ], 'config');
        }

        $this->registerMacros();
        $this->registerRoutes();
        $this->registerMigrations();
    }

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/starsender.php', 'starsender');

        // Register the main class to use with the facade
        $this->app->bind('starsender', function ($app) {
            return new Starsender($app);
        });
    }

    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function registerMacros()
    {
        Http::macro('starsender', function (): PendingRequest {
            $config = config('starsender.api');
            $http = Http::withOptions($config['options'] ?? []);

            $http->withHeaders($config['headers'])->baseUrl($config['url']);

            // if (config('starsender.check_before_send', false)) {
            //     $http->beforeSending(Str::parseCallback("$config[beforeSending]@sending"));
            // }

            $http->beforeSending(Str::parseCallback("$config[beforeSending]@sending"));

            return $http;
        });
    }

    private function registerRoutes()
    {
        if (config('starsender.router.enabled')) {
            Route::group($this->routeConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
            });
        }

        if (config('starsender.webhook.enabled')) {
            Route::group(config('starsender.webhook.router', []), function () {
                Route::post('/', config('starsender.webhook.action'));
            });
        }
    }

    private function routeConfiguration()
    {
        return array_merge([
            'namespace' => 'Kangangga\Starsender\Http\Controllers',
            'prefix' => 'starsender',
            'middleware' => [],
        ], config('starsender.router', []));
    }
}
