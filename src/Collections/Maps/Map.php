<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Exception\OutOfBoundsException;

class Map implements MapInterface
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        if (!is_string($key) && !is_int($key)) {
            throw new InvalidArgumentException('$key must be a string or integer');
        }

        $this->map[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws OutOfBoundsException
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->map)) {
            throw new OutOfBoundsException(sprintf('The key "%s" does not exist', $key));
        }

        return $this->map[$key];
    }

    public function has($key)
    {
        return array_key_exists($key, $this->map);
    }

    public function getKeys()
    {
        return array_keys($this->map);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}
