<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Rest\Api;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCreateBasic(): void
    {
        $actual = new Api('get', (new HttpFactory())->createUri('http://somewhere'));

        $this->assertSame('GET', $actual->getMethod());
        $this->assertSame('http://somewhere', (string)$actual->getUri());
    }
}
