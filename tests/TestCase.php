<?php

namespace IgnitionWolf\API\Modules\Tests;

use Flugg\Responder\ResponderServiceProvider;
use IgnitionWolf\API\ExceptionServiceProvider;
use IgnitionWolf\API\Modules\ModulesServiceProvider;
use IgnitionWolf\API\Support\Stub;
use IgnitionWolf\API\WolfAPIServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected Stub $stub;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->artisan('module:make DummyModule');
        $this->stub = app(Stub::class)->setBasePath(__DIR__ . '/../src/Commands/stubs');
    }

    public function tearDown(): void
    {
        $this->app
            ->make(Filesystem::class)
            ->deleteDirectory($this->app->basePath('Modules'));

        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            WolfAPIServiceProvider::class,
            ExceptionServiceProvider::class,
            ResponderServiceProvider::class,
            QueryBuilderServiceProvider::class,
            LaravelModulesServiceProvider::class,
            ModulesServiceProvider::class
        ];
    }
}
