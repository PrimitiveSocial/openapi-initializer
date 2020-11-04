<?php

namespace Primitive;

use Illuminate\Support\ServiceProvider;
use Primitive\Console\CreateOpenApiContractCommand;

class OpenApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Registering package Console.
        $this->publishesConfig();

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateOpenApiContractCommand::class
            ]);
        }
    }

    public function publishesConfig()
    {
        $this->publishes([
            __DIR__.'/../config/openapi.php' => config_path('openapi.php'),
        ], 'config');
    }
}