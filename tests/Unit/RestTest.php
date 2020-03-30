<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Mocker\Psr18\MockClient;
use MilesChou\Rest\Caller;
use MilesChou\Rest\Rest;
use MilesChou\Rest\HttpFactory\LaminasFactory;
use Tests\TestCase;

class RestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCallAnAddedApi(): void
    {
        $target = new Rest(new LaminasFactory(), new MockClient());

        $target->addApi('foo', 'get', 'http://somewhere');

        $actual = $target->call('foo');

        $this->assertInstanceOf(Caller::class, $actual);

        $this->markTestIncomplete();
    }
}
