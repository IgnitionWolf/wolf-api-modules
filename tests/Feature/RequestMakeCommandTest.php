<?php

namespace IgnitionWolf\API\Modules\Tests\Feature;

use IgnitionWolf\API\Modules\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
    public function test_it_creates_plain_request_file()
    {
        $expectedDestination = $this->app->basePath('Modules/DummyModule/Http/Requests') . '/DummyPlainRequest.php';

        $this->artisan('module:make-request', ['module' => 'DummyModule', 'name' => 'DummyPlainRequest']);
        $this->assertFileExists($expectedDestination);

        $this->assertStringEqualsFile(
            $expectedDestination,
            $this->stub->render('request.stub', [
                '$PARENT_CLASS_NAMESPACE$' => 'IgnitionWolf\\API\\Http\\Requests\\EntityRequest',
                '$PARENT_CLASS$' => 'EntityRequest',
                '$NAMESPACE$' => 'Modules\\DummyModule\\Http\\Requests',
                '$CLASS$' => 'DummyPlainRequest'
            ])
        );

        unlink($expectedDestination);
    }

    public function test_it_creates_api_request_file()
    {
        foreach (['Create', 'Update', 'Delete', 'Read', 'List'] as $request) {
            $class = "${request}DummyRequest";
            $expectedDestination = sprintf(
                '%s/%s.php',
                $this->app->basePath('Modules/DummyModule/Http/Requests'),
                $class
            );

            $this->artisan('module:make-request', ['module' => 'DummyModule', 'name' => $class]);
            $this->assertFileExists($expectedDestination);

            $this->assertStringEqualsFile(
                $expectedDestination,
                $this->stub->render('request-api.stub', [
                    '$PARENT_CLASS_NAMESPACE$' => "IgnitionWolf\\API\\Http\\Requests\\${request}EntityRequest",
                    '$PARENT_CLASS$' => "${request}EntityRequest",
                    '$NAMESPACE$' => 'Modules\\DummyModule\\Http\\Requests',
                    '$CLASS$' => $class,
                ])
            );

            unlink($expectedDestination);
        }
    }
}
