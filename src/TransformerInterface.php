<?php

namespace DCP\Mapper;

interface TransformerInterface
{
    /**
     * Transform a value into a new value.
     *
     * @param mixed $value
     * @return mixed
     */
    public function transform($value);
}
