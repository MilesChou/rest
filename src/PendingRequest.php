<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use MilesChou\Psr\Http\Message\HttpFactoryAwareTrait;
use MilesChou\Psr\Http\Message\PendingRequest as BasePendingRequest;
use MilesChou\Rest\Http\Query;
use Psr\Http\Message\ResponseInterface;

class PendingRequest extends BasePendingRequest
{
    use HttpFactoryAwareTrait;

    /**
     * @return ResponseInterface
     */
    public function __invoke(): ResponseInterface
    {
        return $this->send();
    }

    /**
     * Return query array in request
     *
     * @return array
     */
    public function getQuery(): array
    {
        return Query::parse($this->getUri()->getQuery());
    }

    /**
     * Alias to withQuery()
     *
     * @param array $query
     * @return $this
     */
    public function query(array $query): self
    {
        return $this->withQuery($query);
    }

    /**
     * @param array $array
     * @param string $charset
     * @return static
     */
    public function withJson(array $array, $charset = 'utf-8'): self
    {
        $content = (string)json_encode($array);

        return $this->withHeader('Content-type', 'application/json;charset=' . $charset)
            ->withBody($this->httpFactory->createStream($content));
    }

    /**
     * @param array $array
     * @param string $charset
     * @return static
     */
    public function withFormUrlencoded(array $array, $charset = 'utf-8'): self
    {
        $content = Query::build($array);

        return $this->withHeader('Content-type', 'application/x-www-form-urlencoded;charset=' . $charset)
            ->withBody($this->httpFactory->createStream($content));
    }

    /**
     * @param array $query
     * @return $this
     */
    public function withQuery(array $query): self
    {
        $queryString = Query::build(array_merge($this->getQuery(), $query));

        return $this->withQueryString($queryString);
    }

    /**
     * @param string $query
     * @return $this
     */
    public function withQueryString(string $query): self
    {
        $uri = $this->request->getUri();

        $this->request = $this->request->withUri($uri->withQuery($query));

        return $this;
    }
}
