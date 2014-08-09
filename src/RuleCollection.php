<?php

namespace DCP\Mapper;

use DCP\Mapper\Exception\InvalidArgumentException;

class RuleCollection extends Collection
{
    /**
     * @param RuleInterface $rule
     * @return $this
     * @throws InvalidArgumentException
     */
    public function add($rule)
    {
        if (!($rule instanceof RuleInterface)) {
            throw new InvalidArgumentException('$rule must be an instance of RuleInterface');
        }

        parent::add($rule);
        return $this;
    }
}
