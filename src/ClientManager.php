<?php

namespace MilesChou\Rest;

use OutOfRangeException;
use Psr\Http\Client\ClientInterface;

class ClientManager
{
    /**
     * @var ClientInterface
     */
    private $default;

    /**
     * @var array<ClientInterface>
     */
    private $drivers = [];

    /**
     * ClientManager constructor.
     * @param ClientInterface $default
     */
    public function __construct(ClientInterface $default)
    {
        $this->default = $default;
    }

    /**
     * Register a HTTP client
     *
     * @param string $name
     * @param ClientInterface $client
     */
    public function add(string $name, ClientInterface $client): void
    {
        $this->drivers[$name] = $client;
    }

    /**
     * @return ClientInterface
     */
    public function default(): ClientInterface
    {
        return $this->default;
    }

    /**
     * @param string $name
     * @return ClientInterface
     */
    public function driver(string $name): ClientInterface
    {
        if (!$this->has($name)) {
            throw new OutOfRangeException("Client driver '{$name}' is not found");
        }

        return $this->drivers[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->drivers[$name]);
    }

    /**
     * @param ClientInterface $default
     */
    public function setDefault(ClientInterface $default): void
    {
        $this->default = $default;
    }
}
