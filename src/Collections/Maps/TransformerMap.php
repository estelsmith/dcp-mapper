<?php

namespace DCP\Mapper\Collections\Maps;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Exception\OutOfBoundsException;
use DCP\Mapper\TransformerCollection;
use DCP\Mapper\TransformerInterface;

class TransformerMap extends Map implements CollectionMapInterface
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
        $collection = null;

        try {
            $collection = parent::get($key);
        } catch (OutOfBoundsException $exception) {
            if ($default) {
                $collection = new TransformerCollection();
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
        if (!($value instanceof TransformerInterface)) {
            throw new InvalidArgumentException('$value must be an instance of TransformerInterface');
        }

        $collection = $this->get($key, false);

        if (!$collection) {
            $collection = new TransformerCollection();
            $this->set($key, $collection);
        }

        $collection->add($value);

        return $this;
    }

}
