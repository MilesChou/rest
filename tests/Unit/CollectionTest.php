<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Rest\Api;
use MilesChou\Rest\Collection;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenAdd(): void
    {
        $target = new Collection();
        $target->add('foo', new Api('get', 'http://somewhere'));

        $this->assertTrue($target->has('foo'));
    }
}
