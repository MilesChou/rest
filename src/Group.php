<?php

namespace MilesChou\Rest;

use OutOfRangeException;

class Group
{
    /**
     * @var Rest[]
     */
    protected $rests = [];

    /**
     * @param Rest[] $rests
     */
    public function __construct(array $rests = [])
    {
        $this->init($rests);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function forget(string $name): Group
    {
        unset($this->rests[$name]);

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->rests);
    }

    /**
     * @param string $name
     * @return Rest
     */
    public function get(string $name): Rest
    {
        return $this->resolve($name);
    }

    /**
     * Initial collection object
     *
     * @param Rest[] $mapping
     * @return Group
     */
    public function init(array $mapping): Group
    {
        foreach ($mapping as $name => $client) {
            $this->set($name, $client);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param Rest $client
     * @return Group
     */
    public function set(string $name, Rest $client): Group
    {
        $this->rests[$name] = $client;

        return $this;
    }

    /**
     * @param string $name
     * @return Rest
     */
    protected function resolve(string $name): Rest
    {
        if (!isset($this->rests[$name])) {
            throw new OutOfRangeException("Group '{$name}' is not found");
        }

        return $this->rests[$name];
    }
}
