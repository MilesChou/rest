<?php

namespace MilesChou\Rest\HttpFactory;

use MilesChou\Rest\Contracts\HttpFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

abstract class AbstractHttpFactory implements HttpFactory
{
    /**
     * @var string
     */
    protected $responseFactoryClass;

    /**
     * @var string
     */
    protected $requestFactoryClass;

    /**
     * @var string
     */
    protected $streamFactoryClass;

    /**
     * @var string
     */
    protected $uriFactoryClass;

    /**
     * @var ResponseFactoryInterface|null
     */
    private $responseFactory;

    /**
     * @var RequestFactoryInterface|null
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface|null
     */
    private $streamFactory;

    /**
     * @var UriFactoryInterface|null
     */
    private $uriFactory;

    /**
     * @return ResponseFactoryInterface
     */
    public function responseFactory(): ResponseFactoryInterface
    {
        if ($this->responseFactory instanceof ResponseFactoryInterface) {
            return $this->responseFactory;
        }

        if (class_exists($this->responseFactoryClass)) {
            return $this->responseFactory = $this->createInstance($this->responseFactoryClass, func_get_args());
        }

        throw new \LogicException('ResponseFactory class is not found');
    }

    /**
     * @return RequestFactoryInterface
     */
    public function requestFactory(): RequestFactoryInterface
    {
        if ($this->requestFactory instanceof RequestFactoryInterface) {
            return $this->requestFactory;
        }

        if (class_exists($this->requestFactoryClass)) {
            return $this->requestFactory = $this->createInstance($this->requestFactoryClass, func_get_args());
        }

        throw new \LogicException('RequestFactory class is not found');
    }

    /**
     * @return StreamFactoryInterface
     */
    public function streamFactory(): StreamFactoryInterface
    {
        if ($this->streamFactory instanceof StreamFactoryInterface) {
            return $this->streamFactory;
        }

        if (class_exists($this->streamFactoryClass)) {
            return $this->streamFactory = $this->createInstance($this->streamFactoryClass, func_get_args());
        }

        throw new \LogicException('StreamFactory class is not found');
    }

    /**
     * @return UriFactoryInterface
     */
    public function uriFactory(): UriFactoryInterface
    {
        if ($this->uriFactory instanceof UriFactoryInterface) {
            return $this->uriFactory;
        }

        if (class_exists($this->uriFactoryClass)) {
            return $this->uriFactory = $this->createInstance($this->uriFactoryClass, func_get_args());
        }

        throw new \LogicException('UriFactory class is not found');
    }

    /**
     * @param string $class
     * @param array<mixed> $args
     * @return mixed
     */
    private function createInstance(string $class, array $args = [])
    {
        return new $class(...$args);
    }
}
