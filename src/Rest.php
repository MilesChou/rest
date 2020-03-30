<?php

namespace MilesChou\Rest;

use MilesChou\Rest\Contracts\HttpFactoryInterface;

class Rest
{

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var HttpFactoryInterface
     */
    private $httpFactory;

    /**
     * @param HttpFactoryInterface $httpFactory
     */
    public function __construct(HttpFactoryInterface $httpFactory)
    {
        $this->httpFactory = $httpFactory;
        $this->collection = new Collection();
    }

    /**
     * @param string $name
     * @param string $method
     * @param string $uri
     * @return Api
     */
    public function addApi(string $name, string $method, string $uri): Api
    {
        $api = new Api($method, $this->httpFactory->createUri($uri));

        $this->collection->add($name, $api);

        return $api;
    }

    /**
     * @param string $name
     * @return Caller
     */
    public function call(string $name): Caller
    {
        return new Caller($this->collection->get($name));
    }
}
