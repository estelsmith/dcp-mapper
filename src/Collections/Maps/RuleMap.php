<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Exception\OutOfBoundsException;
use DCP\Mapper\RuleCollection;
use DCP\Mapper\RuleInterface;

class RuleMap extends Map implements CollectionMapInterface
{
    /**
     * @param mixed $key
     * @param RuleCollection $value
     * @return $this
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        if (!($value instanceof RuleCollection)) {
            throw new InvalidArgumentException('$value must be an instance of RuleCollection');
        }

        return parent::set($key, $value);
    }

    /**
     * @param mixed $key
     * @param bool $default
     * @return RuleCollection|RuleInterface[]
     */
    public function get($key, $default = true)
    {
        $collection = null;

        try {
            $collection = parent::get($key);
        } catch (OutOfBoundsException $exception) {
            if ($default) {
                $collection = new RuleCollection();
            }
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function add($key, $value)
    {
        if (!($value instanceof RuleInterface)) {
            throw new InvalidArgumentException('$value must be an instance of RuleInterface');
        }

        $collection = $this->get($key, false);

        if (!$collection) {
            $collection = new RuleCollection();
            $this->set($key, $collection);
        }

        $collection->add($value);

        return $this;
    }
}
