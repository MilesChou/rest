<?php

declare(strict_types=1);

namespace MilesChou\Rest;

class Api
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @param string $method
     * @param string $uri
     * @return Api
     */
    public static function create($method, $uri): Api
    {
        return new self($method, $uri);
    }

    /**
     * @param string $method
     * @param string $uri
     */
    public function __construct(string $method, string $uri)
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
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
