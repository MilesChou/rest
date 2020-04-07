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
        $api = new Api($method, $uri);

        $this->collection->add($name, $api);

        return $api;
    }

    /**
     * @param string $name
     * @return Pending
     */
    public function call(string $name): Pending
    {
        $api = $this->collection->get($name);
        $client = $this->clientManager->driver($api->getDriver());

        return new Pending($client, $api);
    }
}
