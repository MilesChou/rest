<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Mocker\Psr18\MockClient;
use MilesChou\Rest\ClientManager;
use OutOfRangeException;
use Tests\TestCase;

class ClientManagerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnDefaultClient(): void
    {
        $expected = new MockClient();

        $target = new ClientManager($expected);

        $this->assertSame($expected, $target->default());
    }

    /**
     * @test
     */
    public function shouldSwapDefaultClient(): void
    {
        $expected = new MockClient();

        $target = new ClientManager(new MockClient());
        $target->setDefault($expected);

        $this->assertSame($expected, $target->default());
    }

    /**
     * @test
     */
    public function shouldReturnAddedDriver(): void
    {
        $expected = new MockClient();

        $target = new ClientManager(new MockClient());
        $target->add('hello', $expected);

        $this->assertSame($expected, $target->driver('hello'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenDriverNotFound(): void
    {
        $this->expectException(OutOfRangeException::class);

        $target = new ClientManager(new MockClient());

        $target->driver('not-found');
    }
}