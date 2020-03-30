<?php

namespace MilesChou\Rest\HttpFactory;

use Laminas\Diactoros\RequestFactory;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UriFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Bridge to Laminas Factories
 */
class LaminasFactory extends HttpFactory
{
    protected $responseFactoryClass = ResponseFactory::class;

    protected $requestFactoryClass = RequestFactory::class;

    protected $streamFactoryClass = StreamFactory::class;

    protected $uriFactoryClass = UriFactory::class;

    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory()->createResponse($code, $reasonPhrase);
    }

    public function createRequest(string $method, $uri): RequestInterface
    {
        return $this->requestFactory()->createRequest($method, $uri);
    }

    public function createStream(string $content = ''): StreamInterface
    {
        return $this->streamFactory()->createStream($content);
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return $this->streamFactory()->createStreamFromFile($filename, $mode);
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        return $this->streamFactory()->createStreamFromResource($resource);
    }

    public function createUri(string $uri = ''): UriInterface
    {
        return $this->uriFactory()->createUri($uri);
    }
}
