<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Psr\Http\Client\ClientManager;
use MilesChou\Psr\Http\Client\Testing\MockClient;
use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Rest\Rest;
use Tests\TestCase;

class RestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCanCallWhenCallAnAddedApi(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest(new ClientManager($mockClient), new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere');

        $target->call('foo')
            ->send();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere');
    }

    /**
     * @test
     */
    public function shouldCanCallWhenCallAnAddedApiWithQuery(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere');

        $target->call('foo')
            ->withQuery(['foo' => 'bar'])
            ->send();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere?foo=bar');
    }
}
