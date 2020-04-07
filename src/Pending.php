<?php

namespace MilesChou\Rest;

use Psr\Http\Client\ClientInterface;

class Pending
{
    /**
     * @var Api
     */
    private $api;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     * @param Api $api
     */
    public function __construct(ClientInterface $client, Api $api)
    {
        $this->client = $client;
        $this->api = $api;
    }
}
