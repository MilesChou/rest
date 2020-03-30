<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Rest\Api;
use MilesChou\Rest\HttpFactory\LaminasFactory;
use MilesChou\Rest\Collection;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkay(): void
    {
        $target = new Collection();
        $target->add(new Api('get', (new LaminasFactory())->createUri('http://somewhere')));

        $this->markTestIncomplete();
    }
}
