<?php

namespace IgnitionWolf\API\Modules\Tests\Feature;

use IgnitionWolf\API\Modules\Tests\TestCase;
use IgnitionWolf\API\Support\Stub;

class CRUDMakeCommandTest extends TestCase
{
    public function test_it_creates_crud_files()
    {
        $path = $this->app->basePath('Modules/DummyModule/Http/Requests');
        $requests = [
            'Create' => "$path/Dummy/CreateRequest",
            'Read' => "$path/Dummy/ReadRequest",
            'Update' => "$path/Dummy/UpdateRequest",
            'Delete' => "$path/Dummy/DeleteRequest",
            'List' => "$path/Dummy/ListRequest"
        ];

        $this->artisan('module:make-crud', ['module' => 'DummyModule', 'name' => 'Dummy']);

        $this->assertFileExists(
            $this->app->basePath('Modules/DummyModule/Http/Controllers/DummyController.php')
        );

        $this->assertFileExists(
            $this->app->basePath('Modules/DummyModule/Entities/Dummy.php')
        );

        foreach ($requests as $action => $request) {
            $filename = $request . '.php';
            $name = substr($request, strrpos($request, '/') + 1);
            $this->assertFileExists($filename);

            $content = $this->stub->render('request-api.stub', [
                '$PARENT_CLASS_NAMESPACE$' => "IgnitionWolf\\API\\Http\\Requests\\${action}EntityRequest",
                '$PARENT_CLASS$' => "${action}EntityRequest",
                '$NAMESPACE$' => 'Modules\\DummyModule\\Http\\Requests\\Dummy',
                '$CLASS$' => $name
            ]);

            $this->assertStringEqualsFile($filename, $content);
            unlink($filename);
        }
    }
}
