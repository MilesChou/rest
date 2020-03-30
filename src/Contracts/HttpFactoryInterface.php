<?php

namespace MilesChou\Rest\Contracts;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

interface HttpFactoryInterface extends
    RequestFactoryInterface,
    ResponseFactoryInterface,
    StreamFactoryInterface,
    UriFactoryInterface
{
}
