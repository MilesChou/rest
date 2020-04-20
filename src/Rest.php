<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use MilesChou\Psr\Http\Client\ClientManager;
use MilesChou\Psr\Http\Client\ClientManagerInterface;
use MilesChou\Psr\Http\Message\HttpFactory;
use MilesChou\Psr\Http\Message\HttpFactoryAwareTrait;
use MilesChou\Psr\Http\Message\HttpFactoryInterface;
use MilesChou\Rest\Traits\GroupMixin;
use Psr\Http\Client\ClientInterface;

class Rest
{
    use HttpFactoryAwareTrait;
    use GroupMixin;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var ClientManagerInterface
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
        $this->group = new Group();
    }

    /**
     * Proxy to call() method
     */
    public function __call($name, $arguments)
    {
        return $this->call($name, $arguments);
    }

    /**
     * @param string $name
     * @param string $method
     * @param string $uri
     * @param string|null $driver
     * @return Api
     */
    public function addApi(string $name, string $method, string $uri, ?string $driver = null): Api
    {
        $api = new Api($method, $uri, $driver);

        $this->collection->add($name, $api);

        return $api;
    }

    /**
     * @param string $name
     * @param array<int, string> $parameters
     * @return PendingRequest
     */
    public function call(string $name, ...$parameters): PendingRequest
    {
        $api = $this->collection->get($name);

        $request = $this->httpFactory->createRequest(
            $api->getMethod(),
            $this->normalizeUri($api->getUriWithParameters(...$parameters))
        );

        $client = $this->clientManager->driver($api->getDriver());

        return (new PendingRequest($request, $client))->setHttpFactory($this->httpFactory);
    }

    /**
     * @param string $baseUrl
     * @return Rest
     */
    public function setBaseUrl(string $baseUrl): Rest
    {
        // Normalize
        if ('/' === substr($baseUrl, -1)) {
            $baseUrl = substr($baseUrl, 0, -1);
        }

        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param string $uri
     * @return string
     */
    private function normalizeUri(string $uri): string
    {
        $parts = parse_url($uri);

        return array_key_exists('host', $parts) ? $uri : $this->baseUrl . $uri;
    }
}
