<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use InvalidArgumentException;

class Collection
{
    /**
     * @var Api[]
     */
    private $allRests = [];

    /**
     * @var Api[]
     */
    private $nameList = [];

    /**
     * @param string $name
     * @param Api $api
     */
    public function add(string $name, Api $api): void
    {
        $this->nameList[$name] = $api;

        $this->addToCollections($api);
    }

    /**
     * @param string $name
     * @return Api
     */
    public function get(string $name): Api
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException("API '{$name}' is not found");
        }

        return $this->nameList[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->nameList[$name]);
    }

    /**
     * @param Api $api
     */
    protected function addToCollections(Api $api): void
    {
        $this->allRests[$api->getMethod() . $api->getUri()] = $api;
    }
}
