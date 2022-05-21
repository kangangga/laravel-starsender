<?php

namespace Kangangga\Starsender;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kangangga\Starsender\Utils\Endpoint;

class StarsenderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!config('starsender.enabled')) {
            return;
        }

        if (config('starsender.router.enabled')) {
            $this->registerRoutes();
        }

        $this->regsiterMacro();
        $this->registerMigrations();


        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/starsender.php' => config_path('starsender.php'),
            ], 'config');
        }
    }

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/starsender.php', 'starsender');

        // Register the main class to use with the facade
        $this->app->singleton('starsender', function () {
            return new Starsender;
        });
    }

    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function regsiterMacro()
    {
        Http::macro('starsender', function () {
            $config = config('starsender.api');
            return Http::timeout($config['timeout'])
                ->connectTimeout($config['connect_timeout'])
                ->withOptions([
                    'debug' => $config['debug'],
                ])
                ->withHeaders($config['headers'])->baseUrl($config['url']);
        });

        Endpoint::registerMacro();
    }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    private function routeConfiguration()
    {
        return array_merge([
            'namespace' => 'Kangangga\Starsender\Http\Controllers',
            'prefix' => 'starsender',
            'middleware' => [],
        ], config('starsender.router'));
    }
}
