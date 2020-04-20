<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use MilesChou\Psr\Http\Message\HttpFactoryAwareTrait;
use MilesChou\Psr\Http\Message\PendingRequest as BasePendingRequest;
use MilesChou\Rest\Http\Query;

class PendingRequest extends BasePendingRequest
{
    use HttpFactoryAwareTrait;

    /**
     * @param array $array
     * @param string $charset
     * @return $this
     */
    public function withJson(array $array, $charset = 'utf-8'): self
    {
        $content = (string)json_encode($array);

        $this->request = $this->request
            ->withHeader('Content-type', 'application/json;charset=' . $charset)
            ->withBody($this->httpFactory->createStream($content));

        return $this;
    }

    /**
     * @param array $array
     * @param string $charset
     * @return $this
     */
    public function withFormUrlencoded(array $array, $charset = 'utf-8'): self
    {
        $content = Query::build($array);

        $this->request = $this->request
            ->withHeader('Content-type', 'application/x-www-form-urlencoded;charset=' . $charset)
            ->withBody($this->httpFactory->createStream($content));

        return $this;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function withQuery(array $query): self
    {
        return $this->withQueryString(Query::build($query));
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
