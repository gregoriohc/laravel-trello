<?php

namespace Gregoriohc\LaravelTrello;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class TrelloServiceProvider extends LaravelServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->handleConfigs();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->app->singleton("trello", function($app) {
            return new Wrapper($app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return [];
    }

    private function handleConfigs() {

        $configPath = __DIR__ . '/../config/trello.php';

        $this->publishes([$configPath => config_path('trello.php')]);

        $this->mergeConfigFrom($configPath, 'trello');
    }
}
