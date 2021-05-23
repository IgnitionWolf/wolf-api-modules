<?php

namespace IgnitionWolf\API\Modules\Tests\Feature;

use IgnitionWolf\API\Modules\Tests\TestCase;

class AutomapMakeCommandTest extends TestCase
{
    public function test_it_creates_automap_file()
    {
        $expectedDestination = $this->app->basePath('Modules/DummyModule/Automap') . '/DummyAutomap.php';

        $this->artisan('module:make-automap', ['name' => 'DummyAutomap', 'module' => 'DummyModule']);

        $this->assertStringEqualsFile(
            $expectedDestination,
            $this->stub->render('automap.stub', [
                '$NAMESPACE$' => 'Modules\\DummyModule\\Automap',
                '$CLASS$' => 'DummyAutomap'
            ])
        );

        unlink($expectedDestination);
    }
}
