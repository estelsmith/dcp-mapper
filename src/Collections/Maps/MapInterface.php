<?php

namespace DCP\Mapper\Collections\Maps;

interface MapInterface extends \IteratorAggregate
{
    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value);

    /**
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param mixed $key
     * @return bool
     */
    public function has($key);

    /**
     * @return array
     */
    public function getKeys();
}
