<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Exception\OutOfBoundsException;
use DCP\Mapper\TransformerCollection;
use DCP\Mapper\TransformerInterface;

class TransformerMap extends CollectionMap
{
    /**
     * @param mixed $key
     * @param TransformerCollection $value
     * @return $this
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        if (!($value instanceof TransformerCollection)) {
            throw new InvalidArgumentException('$value must be an instance of TransformerCollection');
        }

        return parent::set($key, $value);
    }

    /**
     * @param mixed $key
     * @param bool $default
     * @return TransformerCollection|TransformerInterface[]
     */
    public function get($key, $default = true)
    {
        return parent::get($key, $default, function () {
            return new TransformerCollection();
        });
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function add($key, $value)
    {
        return $this->addWithTypeCheck($key, $value, 'DCP\Mapper\TransformerInterface', function () {
            return new TransformerCollection();
        });
    }
}
