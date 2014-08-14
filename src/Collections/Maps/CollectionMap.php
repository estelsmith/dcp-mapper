<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Collection;
use DCP\Mapper\Exception\OutOfBoundsException;

abstract class CollectionMap extends Map implements CollectionMapInterface
{
    public function get($key, callable $defaultCallback = null)
    {
        $collection = null;

        try {
            $collection = parent::get($key);
        } catch (OutOfBoundsException $exception) {
            if ($defaultCallback) {
                $collection = call_user_func($defaultCallback);
            }
        }

        return $collection;
    }

    public function add($key, $value, callable $defaultCollectionCallback = null)
    {
        $collection = $this->get($key, null);

        if (!$collection) {
            /** @var Collection $collection */
            $collection = call_user_func($defaultCollectionCallback);
            $this->set($key, $collection);
        }

        $collection->add($value);

        return $this;
    }
}
