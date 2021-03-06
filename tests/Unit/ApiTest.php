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
    public function shouldReturnKeysWhenCreateWithParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertTrue($target->hasParameter());
        $this->assertSame(['foo', 'bar'], $target->parameterKeys());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenNoParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/');

        $this->assertFalse($target->hasParameter());
        $this->assertSame([], $target->parameterKeys());
    }

    /**
     * @test
     */
    public function shouldBindParametersWhenGetUriWithParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithParameters(['foo' => 1, 'bar' => 2]));
    }

    /**
     * @test
     */
    public function shouldBindParametersWhenGetUriWithParametersBySequence(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithParameters([1, 2]));
    }

    /**
     * @test
     */
    public function shouldBindParametersWhenGetUriWithParametersByMultiArgs(): void
    {
        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithParameters(1, 2));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingIsNotCompleted(): void
    {
        $this->expectException(RuntimeException::class);

        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithParameters(['foo' => 1]));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingIsNotCompletedBySequence(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $target = new Api('GET', 'http://somewhere/{foo}/{bar}');

        $this->assertSame('http://somewhere/1/2', $target->getUriWithParameters(1));
    }

    /**
     * @test
     */
    public function shouldDoNothingWhenNoParameters(): void
    {
        $target = new Api('GET', 'http://somewhere/');

        $this->assertSame('http://somewhere/', $target->getUriWithParameters(['foo' => 1]));
        $this->assertSame('http://somewhere/', $target->getUriWithParameters([1, 2]));
        $this->assertSame('http://somewhere/', $target->getUriWithParameters(1, 2));
        $this->assertSame('http://somewhere/', $target->getUriWithParameters());
    }
}
