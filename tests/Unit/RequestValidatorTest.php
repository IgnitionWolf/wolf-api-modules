<?php

namespace IgnitionWolf\API\Modules\Tests\Unit;

use IgnitionWolf\API\Exceptions\NotAuthorizedException;
use IgnitionWolf\API\Http\Requests\EntityRequest;
use IgnitionWolf\API\Validator\RequestValidator;
use IgnitionWolf\API\Modules\Tests\TestCase;

class RequestValidatorTest extends TestCase
{
    public function test_it_provides_request()
    {
        $this->expectException(NotAuthorizedException::class);
        $request = app(RequestValidator::class)->validate('Modules\\DummyModule\\Entities\\Dummy', 'create');
        $this->assertInstanceOf(EntityRequest::class, $request);
    }

    public function test_it_provides_request_options()
    {
        $options = app(RequestValidator::class)->getOptions('Modules\\DummyModule', 'Dummy', 'Create');

        $this->assertContains('Modules\\DummyModule\\Http\\Requests\\CreateDummyRequest', $options);
        $this->assertContains('Modules\\DummyModule\\Http\\Requests\\Dummy\\CreateRequest', $options);
        $this->assertContains('IgnitionWolf\\API\\Http\\Requests\\EntityRequest', $options);
    }
}
