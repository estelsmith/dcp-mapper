<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Collection;
use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Exception\OutOfBoundsException;

abstract class CollectionMap extends Map implements CollectionMapInterface
{
    public function get($key, $default = true, $callback = null)
    {
        if ($default) {
            return $this->getWithCallback($key, $callback);
        }

        return $this->getWithCallback($key, null);
    }

    public function add($key, $value, callable $defaultCollectionCallback = null)
    {
        $collection = self::get($key, false);

        if (!$collection) {
            /** @var Collection $collection */
            $collection = call_user_func($defaultCollectionCallback);
            $this->set($key, $collection);
        }

        $collection->add($value);

        return $this;
    }

    protected function getWithCallback($key, callable $defaultCallback = null)
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

    protected function addWithTypeCheck($key, $value, $type, callable $callback = null)
    {
        if (!(is_object($value) && is_subclass_of($value, $type))) {
            throw new InvalidArgumentException(sprintf('$value must be an instance of %s', $type));
        }

        return self::add($key, $value, $callback);
    }
}
