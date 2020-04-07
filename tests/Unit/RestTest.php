<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Psr\Http\Client\Testing\MockClient;
use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Rest\Pending;
use MilesChou\Rest\Rest;
use Tests\TestCase;

class RestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCallAnAddedApi(): void
    {
        $target = new Rest(new MockClient(), new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere');

        $actual = $target->call('foo');

        $this->assertInstanceOf(Pending::class, $actual);

        $this->markTestIncomplete();
    }
}
