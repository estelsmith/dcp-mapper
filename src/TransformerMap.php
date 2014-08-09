<?php

namespace DCP\Mapper;

use DCP\Mapper\Exception\InvalidArgumentException;

class TransformerMap
{
    /**
     * @var TransformerCollection[]
     */
    private $transformers = [];

    /**
     * @param string $field
     * @param TransformerInterface $transformer
     * @return $this
     * @throws InvalidArgumentException
     */
    public function add($field, TransformerInterface $transformer)
    {
        if (!is_string($field)) {
            throw new InvalidArgumentException('$field must be a string');
        }

        $transformers = &$this->transformers;

        if (!array_key_exists($field, $transformers)) {
            $transformers[$field] = new TransformerCollection();
        }

        $transformers[$field]->add($transformer);

        return $this;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->transformers);
    }

    /**
     * @param string $field
     * @return TransformerCollection
     */
    public function getTransformers($field)
    {
        if (array_key_exists($field, $this->transformers)) {
            return $this->transformers[$field];
        }

        return null;
    }
}
