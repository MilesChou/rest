<?php

declare(strict_types=1);

namespace MilesChou\Rest\Traits;

use InvalidArgumentException;
use MilesChou\Rest\Rest;

trait GroupMixin
{
    use GroupAwareTrait;

    public function __get($name)
    {
        return $this->group->get($name);
    }

    public function __set($name, $value)
    {
        if (!$value instanceof Rest) {
            $type = \gettype($value);

            if ('object' === $type) {
                $type = \get_class($value);
            }

            throw new InvalidArgumentException("Property must be instance of Rest. Given is {$type}");
        }

        $this->group->set($name, $value);
    }

    public function __isset($name)
    {
        return $this->group->has($name);
    }

    public function __unset($name)
    {
        $this->group->forget($name);
    }
}
