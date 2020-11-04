<?php

namespace Primitive;

use Illuminate\Support\ServiceProvider;
use Primitive\Console\CreateOpenApiContractCommand;

class OpenApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Registering package Console.
        $this->mergeConfigFrom(__DIR__.'/../config/openapi.php', 'openapi');
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateOpenApiContractCommand::class
            ]);
        }
    }
}