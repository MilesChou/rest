<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Rest\Api;
use MilesChou\Rest\HttpFactory\LaminasFactory;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCreateBasic(): void
    {
        $actual = new Api('get', (new LaminasFactory())->createUri('http://somewhere'));

        $this->assertSame('GET', $actual->getMethod());
        $this->assertSame('http://somewhere', (string)$actual->getUri());
    }
}
