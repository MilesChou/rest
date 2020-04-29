<?php

declare(strict_types=1);

namespace MilesChou\Rest;

use MilesChou\Psr\Container\ContainerAwareTrait;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Simplify version from Laravel Pipeline
 *
 * @link https://github.com/laravel/framework/blob/v7.9.2/src/Illuminate/Pipeline/Pipeline.php
 */
class Pipeline
{
    use ContainerAwareTrait;

    /**
     * The object being passed through the pipeline.
     *
     * @var mixed
     */
    protected $passable;

    /**
     * The array of class pipes.
     *
     * @var array
     */
    protected $pipes = [];

    /**
     * @param ContainerInterface|null $container
     * @return void
     */
    public function __construct(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Set the object being sent through the pipeline.
     *
     * @param mixed $passable
     * @return $this
     */
    public function send($passable): self
    {
        $this->passable = $passable;

        return $this;
    }

    /**
     * Set the array of pipes.
     *
     * @param array|mixed $pipes
     * @return $this
     */
    public function through($pipes): self
    {
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();

        return $this;
    }

    /**
     * Run the pipeline with a final destination callback.
     *
     * @param callable $destination
     * @return mixed
     */
    public function then(callable $destination)
    {
        $pipeline = array_reduce(
            array_reverse($this->pipes),
            $this->carry(),
            $this->prepareDestination($destination)
        );

        return $pipeline($this->passable);
    }

    /**
     * Run the pipeline and return the result.
     *
     * @return mixed
     */
    public function thenReturn()
    {
        return $this->then(static function ($passable) {
            return $passable;
        });
    }

    /**
     * Get the final piece of the Closure onion.
     *
     * @param callable $destination
     * @return callable
     */
    private function prepareDestination(callable $destination): callable
    {
        return static function ($passable) use ($destination) {
            return $destination($passable);
        };
    }

    /**
     * Get a Closure that represents a slice of the onion.
     *
     * @return callable
     */
    private function carry(): callable
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                // If the pipe is a callable, then call it directly
                if (is_callable($pipe)) {
                    return $pipe($passable, $stack);
                }

                // If the pipe is a string, the resolve as class
                if (is_string($pipe)) {
                    $pipe = $this->getContainer()->get($pipe);

                    return $pipe($passable, $stack);
                }

                throw new RuntimeException('Can not parse the pipe');
            };
        };
    }

    /**
     * @return ContainerInterface
     * @throws RuntimeException
     */
    private function getContainer(): ContainerInterface
    {
        if (null === $this->container) {
            throw new RuntimeException('A container instance has not been passed to the Pipeline.');
        }

        return $this->container;
    }
}
