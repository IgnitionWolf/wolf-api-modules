<?php

namespace IgnitionWolf\API\Modules\Tests\Feature;

use IgnitionWolf\API\Modules\Tests\TestCase;

class ControllerMakeCommandTest extends TestCase
{
    public function test_it_creates_plain_controller_file()
    {
        $expectedDestination = $this->app->basePath('Modules/DummyModule/Http/Controllers/DummyPlainController.php');

        $this->artisan('module:make-controller', ['module' => 'DummyModule', 'controller' => 'DummyPlainController']);
        $this->assertFileExists($expectedDestination);

        $this->assertStringEqualsFile(
            $expectedDestination,
            $this->stub->render('controller-plain.stub', [
                '$CLASS_NAMESPACE$' => 'Modules\\DummyModule\\Http\\Controllers',
                '$CLASS$' => 'DummyPlainController'
            ])
        );

        unlink($expectedDestination);
    }

    public function test_it_creates_api_controller_file()
    {
        $expectedDestination = $this->app->basePath('Modules/DummyModule/Http/Controllers/DummyApiController.php');

        $this->artisan('module:make-controller', ['module' => 'DummyModule', 'controller' => 'DummyApiController', '--api' => true]);
        $this->assertFileExists($expectedDestination);

        $this->assertStringEqualsFile(
            $expectedDestination,
            $this->stub->render('controller-api.stub', [
                '$CLASS_NAMESPACE$' => 'Modules\\DummyModule\\Http\\Controllers',
                '$CLASS$' => 'DummyApiController'
            ])
        );

        unlink($expectedDestination);
    }
}
