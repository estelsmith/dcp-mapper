<?php

namespace DCP\Mapper\Collections\Maps;

interface CollectionMapInterface
{
    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function add($key, $value);
}
