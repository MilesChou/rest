<?php

namespace MilesChou\Rest;

use MilesChou\Psr\Http\Message\PendingRequest as BasePendingRequest;
use MilesChou\Rest\Http\Query;

class PendingRequest extends BasePendingRequest
{
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
