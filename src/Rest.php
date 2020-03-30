<?php

namespace MilesChou\Rest;

use MilesChou\Rest\Contracts\HttpFactoryInterface;
use Psr\Http\Client\ClientInterface;

class Rest
{
    /**
     * @var ClientManager
     */
    private $clientManager;

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
     * @param ClientInterface $clientManager
     */
    public function __construct(HttpFactoryInterface $httpFactory, ClientInterface $clientManager)
    {
        $this->httpFactory = $httpFactory;
        $this->collection = new Collection();

        if (!$clientManager instanceof ClientManager) {
            $clientManager = new ClientManager($clientManager);
        }

        $this->clientManager = $clientManager;
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
        $api = $this->collection->get($name);
        $client = $this->clientManager->driver($api->getDriver());

        return new Caller($client, $api);
    }
}
