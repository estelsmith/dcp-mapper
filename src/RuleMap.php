<?php

namespace DCP\Mapper;

use DCP\Mapper\Exception\InvalidArgumentException;

class RuleMap
{
    /**
     * @var RuleCollection[]
     */
    private $rules = [];

    /**
     * @param string $field
     * @param RuleInterface $rule
     * @return $this
     * @throws InvalidArgumentException
     */
    public function add($field, RuleInterface $rule)
    {
        if (!is_string($field)) {
            throw new InvalidArgumentException('$field must be a string');
        }

        $rules = &$this->rules;

        if (!array_key_exists($field, $rules)) {
            $rules[$field] = new RuleCollection();
        }

        $rules[$field]->add($rule);

        return $this;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->rules);
    }

    /**
     * @param string $field
     * @return RuleCollection
     */
    public function getRules($field)
    {
        if (array_key_exists($field, $this->rules)) {
            return $this->rules[$field];
        }

        return null;
    }
}
