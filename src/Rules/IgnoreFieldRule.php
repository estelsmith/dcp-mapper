<?php

namespace DCP\Mapper\Rules;

use DCP\Mapper\RuleInterface;

class IgnoreFieldRule implements RuleInterface
{
    public function execute()
    {
        return false;
    }
}
