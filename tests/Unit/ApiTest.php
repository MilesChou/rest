<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use MilesChou\Rest\Api;
use RuntimeException;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCreateBasic(): void
    {
        $target = new Api('get', 'http://somewhere', 'foo');

        $this->assertSame('foo', $target->getDriver());
        $this->assertSame('GET', $target->getMethod());
        $this->assertSame('http://somewhere', $target->getUri());
    }

    /**
     * @test
     */
    public function shouldReturnKeysWhenCreateWithPathParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertTrue($target->hasPathParameter());
        $this->assertSame(['foo', 'bar'], $target->getPathParameter());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenNoPathParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/');

        $this->assertFalse($target->hasPathParameter());
        $this->assertSame([], $target->getPathParameter());
    }

    /**
     * @test
     */
    public function shouldBindPathParametersWhenGetUriWithPathParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithPathParameters(['foo' => 1, 'bar' => 2]));
    }

    /**
     * @test
     */
    public function shouldBindPathParametersWhenGetUriWithPathParametersBySequence(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithPathParameters([1, 2]));
    }

    /**
     * @test
     */
    public function shouldBindPathParametersWhenGetUriWithPathParametersByMultiArgs(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithPathParameters(1, 2));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingIsNotCompleted(): void
    {
        $this->expectException(RuntimeException::class);

        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithPathParameters(['foo' => 1]));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingIsNotCompletedBySequence(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithPathParameters(1));
    }

    /**
     * @test
     */
    public function shouldDoNothingWhenNoPathParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/');

        $this->assertSame('http://somewhere/', $target->getUriWithPathParameters(['foo' => 1]));
        $this->assertSame('http://somewhere/', $target->getUriWithPathParameters([1, 2]));
        $this->assertSame('http://somewhere/', $target->getUriWithPathParameters(1, 2));
        $this->assertSame('http://somewhere/', $target->getUriWithPathParameters());
    }
}
