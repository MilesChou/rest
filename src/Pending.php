<?php

namespace MilesChou\Rest;

use MilesChou\Psr\Http\Client\ClientAwareTrait;
use MilesChou\Psr\Http\Message\HttpFactoryAwareTrait;
use MilesChou\Psr\Http\Message\HttpFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Pending
{
    use ClientAwareTrait;
    use HttpFactoryAwareTrait;

    /**
     * @var Api
     */
    private $api;

    /**
     * @param ClientInterface $httpClient
     * @param HttpFactoryInterface $httpFactory
     * @param Api $api
     */
    public function __construct(ClientInterface $httpClient, HttpFactoryInterface $httpFactory, Api $api)
    {
        $this->setHttpClient($httpClient);
        $this->setHttpFactory($httpFactory);

        $this->api = $api;
    }

    /**
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function sendRequest(): ResponseInterface
    {
        return $this->httpClient->sendRequest($this->createRequest());
    }

    /**
     * @return RequestInterface
     */
    private function createRequest(): RequestInterface
    {
        return $this->httpFactory->createRequest($this->api->getMethod(), $this->api->getUri());
    }
}
