<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use Psr\Http\Message\UriInterface;

class Api
{
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
     */
    public function __construct(string $method, UriInterface $uri)
    {
        $this->method = strtoupper($method);
        $this->uri = $uri;
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
