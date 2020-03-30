<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use Psr\Http\Message\UriInterface;

class Api
{
    /**
     * Client driver
     *
     * @var string|null
     */
    private $driver;

    /**
     * @var string
     */
    private $method;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @param string $method
     * @param UriInterface $uri
     * @param string|null $driver
     */
    public function __construct(string $method, UriInterface $uri, ?string $driver = null)
    {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->driver = $driver;
    }

    /**
     * @return string|null
     */
    public function getDriver(): ?string
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return UriInterface
     *
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }
}
