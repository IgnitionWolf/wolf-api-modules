<?php

namespace IgnitionWolf\API\Modules\Tests\Feature;

use IgnitionWolf\API\Modules\Tests\TestCase;

class TransformerMakeCommandTest extends TestCase
{
    public function test_it_creates_transformer_file()
    {
        $expectedDestination = $this->app->basePath('Modules/DummyModule/Transformers') . '/DummyTransformer.php';

        $this->artisan('module:make-transformer', ['name' => 'DummyTransformer', 'module' => 'DummyModule']);

        $this->assertStringEqualsFile(
            $expectedDestination,
            $this->stub->render('transformer.stub', [
                '$NAMESPACE$' => 'Modules\\DummyModule\\Transformers',
                '$CLASS$' => 'DummyTransformer'
            ])
        );

        unlink($expectedDestination);
    }
}
