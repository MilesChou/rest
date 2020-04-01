<?php

namespace MilesChou\Rest;

use MilesChou\Psr\Http\Client\ClientManager;
use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Psr\Http\Message\HttpFactoryAwareTrait;
use MilesChou\Psr\Http\Message\HttpFactoryInterface;
use Psr\Http\Client\ClientInterface;

class Rest
{
    use HttpFactoryAwareTrait;

    /**
     * @var ClientManager
     */
    private $clientManager;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @param ClientInterface $clientManager
     * @param HttpFactoryInterface $httpFactory
     */
    public function __construct(ClientInterface $clientManager, HttpFactoryInterface $httpFactory = null)
    {
        if (!$clientManager instanceof ClientManager) {
            $clientManager = new ClientManager($clientManager);
        }

        $this->clientManager = $clientManager;
        $this->httpFactory = $httpFactory ?? new HttpFactory();
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
        $api = $this->collection->get($name);
        $client = $this->clientManager->driver($api->getDriver());

        return new Caller($client, $api);
    }
}
