<?php

declare(strict_types=1);

namespace MilesChou\Rest;

class Collection
{
    /**
     * @var Api[]
     */
    protected $allRests = [];

    /**
     * @param Api $api
     */
    public function add(Api $api): void
    {
        $this->addToCollections($api);
    }

    /**
     * @param Api $api
     */
    protected function addToCollections(Api $api): void
    {
        $this->allRests[$api->getMethod() . $api->getUri()] = $api;
    }
}
