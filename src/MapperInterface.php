<?php

namespace DCP\Mapper;

interface MapperInterface
{
    /**
     * @param  mixed $source
     * @param  mixed $target
     * @return mixed
     */
    public function map($source, $target);
}
