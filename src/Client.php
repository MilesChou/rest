<?php

namespace MilesChou\Rest;

use MilesChou\Rest\Contracts\HttpFactoryInterface;

class Client
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
     * @param string $method
     * @param string $uri
     * @return Api
     */
    public function addApi(string $method, string $uri): Api
    {
        $api = new Api($method, $this->httpFactory->createUri($uri));

        $this->collection->add($api);

        return $api;
    }
}
