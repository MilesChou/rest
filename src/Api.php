<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use InvalidArgumentException;
use RuntimeException;

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
     * @var string
     */
    private $uri;

    /**
     * @param array<mixed> $parameters
     * @return bool
     */
    private static function guessParametersIsSequence(array $parameters): bool
    {
        $keys = array_keys($parameters);

        return \is_int($keys[0]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param string|null $driver
     */
    public function __construct(string $method, string $uri, ?string $driver = null)
    {
        $this->method = strtoupper($method);
        $this->uri = $this->normalizeUri($uri);
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
     * @return array<string>
     */
    public function getPathParameter(): array
    {
        preg_match_all('/\/{(.*)}/U', $this->uri, $binding);

        return $binding[1];
    }

    /**
     * @return bool
     */
    public function hasPathParameter(): bool
    {
        return (bool)preg_match('/{.+}/', $this->uri);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param array<int, mixed> $parameters
     * @return string
     */
    public function getUriWithPathParameters(...$parameters): string
    {
        if (!$this->hasPathParameter()) {
            return $this->uri;
        }

        if (is_array($parameters[0])) {
            $parameters = $parameters[0];
        }

        $uri = $this->getUri();

        if (self::guessParametersIsSequence($parameters)) {
            $parameters = $this->buildParametersBySequence($parameters);
        }

        foreach ($parameters as $key => $value) {
            $uri = str_replace("{{$key}}", $value, $uri);
        }

        if (preg_match('/{.+}/', $uri)) {
            throw new RuntimeException('Binding not complete');
        }

        return $uri;
    }

    /**
     * @param array $values
     * @return array
     * @throws InvalidArgumentException
     */
    private function buildParametersBySequence(array $values): array
    {
        $keys = $this->getPathParameter();

        if (count($keys) !== count($values)) {
            throw new InvalidArgumentException('Parameters count is invalid');
        }

        return array_combine($keys, $values);
    }

    /**
     * @param string $uri
     * @return string
     */
    private function normalizeUri(string $uri): string
    {
        $parts = parse_url($uri);

        if ($parts === false) {
            throw new InvalidArgumentException("Unable to parse URI: $uri");
        }

        // Has scheme and host
        if (array_key_exists('host', $parts)) {
            return $uri;
        }

        // No scheme or host
        return strpos($uri, '/') === 0 ? $uri : '/' . $uri;
    }
}
