<?php

namespace Primitive;

use Illuminate\Support\ServiceProvider;
use Primitive\Console\CreateOpenApiContractCommand;

class OpenApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/openapi.php' => config_path('openapi.php'),
            ], 'config');

            $this->commands([
                CreateOpenApiContractCommand::class
            ]);
        }
    }
}