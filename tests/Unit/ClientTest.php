<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Rest\Client;
use MilesChou\Rest\HttpFactory\LaminasFactory;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenAddApi(): void
    {
        $target = new Client(new LaminasFactory());

        $target->addApi('get', 'http://somewhere');

        $this->markTestIncomplete();
    }
}
