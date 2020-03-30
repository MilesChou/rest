<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Rest\Api;
use MilesChou\Rest\RestCollection;
use Tests\TestCase;

class RestCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkay(): void
    {
        $target = new RestCollection();
        $target->add(Api::create('get', 'somewhere'));

        $this->markTestIncomplete();
    }
}
