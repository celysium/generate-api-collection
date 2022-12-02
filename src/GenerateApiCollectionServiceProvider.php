<?php

namespace Celysium\GenerateApiCollection;

use Celysium\GenerateApiCollection\Console\GenerateCollection;
use Illuminate\Support\ServiceProvider;

class GenerateApiCollectionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            GenerateCollection::class
        ]);
    }

    public function register()
    {
        //
    }
}
