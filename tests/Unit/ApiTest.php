<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Rest\Api;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCreateBasic(): void
    {
        $actual = Api::create('get', 'somewhere');

        $this->assertSame('GET', $actual->getMethod());
        $this->assertSame('somewhere', $actual->getUri());
    }
}
