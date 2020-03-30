<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Rest\Caller;
use MilesChou\Rest\Client;
use MilesChou\Rest\HttpFactory\LaminasFactory;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCallAnAddedApi(): void
    {
        $target = new Client(new LaminasFactory());

        $target->addApi('foo', 'get', 'http://somewhere');

        $actual = $target->call('foo');

        $this->assertInstanceOf(Caller::class, $actual);

        $this->markTestIncomplete();
    }
}
