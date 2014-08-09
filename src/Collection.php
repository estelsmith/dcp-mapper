<?php

namespace DCP\Mapper;

abstract class Collection implements \Iterator
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $position = 0;

    public function add($value)
    {
        $this->data[] = $value;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function current()
    {
        return $this->data[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->data);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
