<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Rest\HttpFactory\LaminasFactory;
use Tests\TestCase;

class LaminasFactoryTest extends TestCase
{
    /**
     * @var LaminasFactory
     */
    private $target;

    protected function setUp(): void
    {
        parent::setUp();

        $this->target = new LaminasFactory();
    }

    protected function tearDown(): void
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldReturnNewResponse(): void
    {
        $actual = $this->target->createResponse();

        $this->assertSame('', (string)$actual->getBody());
    }

    /**
     * @test
     */
    public function shouldReturnNewRequest(): void
    {
        $actual = $this->target->createRequest('GET', 'http://somewhere');

        $this->assertSame('GET', $actual->getMethod());
        $this->assertSame('http://somewhere', (string)$actual->getUri());
    }

    /**
     * @test
     */
    public function shouldReturnNewStream(): void
    {
        $actual = $this->target->createStream('Hello');

        $this->assertSame('Hello', (string)$actual);
    }

    /**
     * @test
     */
    public function shouldReturnNewUri(): void
    {
        $actual = $this->target->createUri('http://somewhere');

        $this->assertSame('http://somewhere', (string)$actual);
    }
}
