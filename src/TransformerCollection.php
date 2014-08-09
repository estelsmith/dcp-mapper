<?php

namespace DCP\Mapper;

use DCP\Mapper\Exception\InvalidArgumentException;

class TransformerCollection extends Collection
{
    /**
     * @param TransformerInterface $transformer
     * @return $this
     * @throws InvalidArgumentException
     */
    public function add($transformer)
    {
        if (!($transformer instanceof TransformerInterface)) {
            throw new InvalidArgumentException('$transformer must be an instance of TransformerInterface');
        }

        parent::add($transformer);
        return $this;
    }

    /**
     * @return TransformerInterface[]
     */
    public function toArray()
    {
        return parent::toArray();
    }
}
