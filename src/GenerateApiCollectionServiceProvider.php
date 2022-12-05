<?php

namespace Celysium\GenerateApiCollection;

use Celysium\GenerateApiCollection\Console\GenerateCollection;
use Illuminate\Support\ServiceProvider;

class GenerateApiCollectionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/generate_collection.php' => config_path('generate_collection.php'),
            ], 'generate-collection-config');
        }
        
        $this->commands([
            GenerateCollection::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/generate_collection.php', 'generate_collection'
        );
    }
}
