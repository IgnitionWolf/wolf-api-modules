<?php

namespace IgnitionWolf\API\Modules;

use IgnitionWolf\API\Modules\Commands\AutomapMakeCommand;
use IgnitionWolf\API\Modules\Commands\RequestMakeCommand;
use IgnitionWolf\API\Modules\Commands\CRUDMakeCommand;
use IgnitionWolf\API\Modules\Commands\TransformerMakeCommand;
use IgnitionWolf\API\Validator\RequestValidator;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Support\Stub;

class ModulesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            /**
             * Order laravel-modules package generators to use our new stubs.
             * @package nwidart/laravel-modules
             */
            Stub::setBasePath(sprintf("%s/Commands/stubs", __DIR__));

            $this->commands([
                AutomapMakeCommand::class,
                CRUDMakeCommand::class,
                RequestMakeCommand::class,
                TransformerMakeCommand::class
            ]);
        }
    }

    public function register()
    {
        $this->app->extend(RequestValidator::class, function () {
            return app(\IgnitionWolf\API\Modules\Validator\RequestValidator::class);
        });
    }
}
