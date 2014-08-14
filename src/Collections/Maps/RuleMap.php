<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\RuleCollection;
use DCP\Mapper\RuleInterface;

class RuleMap extends CollectionMap
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
        $defaultCallback = null;

        if ($default) {
            $defaultCallback = function () {
                return new RuleCollection();
            };
        }

        return parent::get($key, $defaultCallback);
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function add($key, $value)
    {
        return $this->addWithTypeCheck($key, $value, 'DCP\Mapper\RuleInterface', function () {
            return new RuleCollection();
        });
    }
}
