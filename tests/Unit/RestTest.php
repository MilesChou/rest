<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Psr\Http\Client\ClientManager;
use MilesChou\Psr\Http\Client\Testing\MockClient;
use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Rest\Group;
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
    public function shouldCanCallUseMagicMethod(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere/{path}');

        $target->foo('bar')
            ->send();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere/bar');
    }

    /**
     * @test
     */
    public function shouldCanCallWhenCallAnAddedApiQuery(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere');

        $target->call('foo')->query(['foo' => 'bar'])();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere?foo=bar');
    }

    /**
     * @test
     */
    public function shouldAppendWhenCallApiWithQuery(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest($mockClient, new HttpFactory());

        $target->addApi('foo', 'get', 'http://somewhere?foo=bar');

        $target->call('foo')->query(['baz' => 'world'])();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere?foo=bar&baz=world');
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

    /**
     * @test
     */
    public function shouldCanCallWhenCallAddedRestGroup(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $added = new Rest($mockClient, new HttpFactory());
        $added->addApi('foo', 'POST', 'http://somewhere');

        $group = (new Group())->set('some', $added);

        $target = new Rest($mockClient, new HttpFactory());
        $target->setGroup($group);

        $target->some->foo()
            ->send();

        $mockClient->testRequest()
            ->assertMethod('POST')
            ->assertUri('http://somewhere');
    }
    /**
     * @test
     */
    public function shouldCanCallWhenCallApiWithBaseUrl(): void
    {
        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new Rest(new ClientManager($mockClient), new HttpFactory());

        $target->addApi('foo', 'get', '/foo/{bar}');
        $target->setBaseUrl('http://somewhere/');

        $target->call('foo', 'some')
            ->send();

        $mockClient->testRequest()
            ->assertMethod('GET')
            ->assertUri('http://somewhere/foo/some');
    }
}
