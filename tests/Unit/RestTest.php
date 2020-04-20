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
    public function shouldCanCallWhenCallAnAddedApiWithPathParameter(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere/{path}');

        $target->call('foo', 'bar')
            ->send();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere/bar');
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

    /**
     * @test
     */
    public function shouldCanCallWhenCallAnAddedApiWithHeader(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere');

        $target->call('foo')
            ->withHeader('foo', 'bar')
            ->send();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere')
            ->assertHeader('foo', 'bar');
    }

    /**
     * @test
     */
    public function shouldCanCallWhenCallAnAddedApiWithJson(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'POST', 'http://somewhere');

        $target->call('foo')
            ->withJson(['foo' => 'bar'])
            ->send();

        $mockClient->testRequest()
            ->assertMethod('POST')
            ->assertUri('http://somewhere')
            ->assertContentTypeIsJson()
            ->assertBodyContains('{"foo":"bar"}');
    }

    /**
     * @test
     */
    public function shouldCanCallWhenCallAnAddedApiWithFormUrlencoded(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'POST', 'http://somewhere');

        $target->call('foo')
            ->withFormUrlencoded(['foo' => 'bar'])
            ->send();

        $mockClient->testRequest()
            ->assertMethod('POST')
            ->assertUri('http://somewhere')
            ->assertContentType('application/x-www-form-urlencoded')
            ->assertBodyContains('foo=bar');
    }
}
