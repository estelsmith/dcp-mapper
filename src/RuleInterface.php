<?php

namespace DCP\Mapper;

interface RuleInterface
{
    /**
     * Determine if a field should be mapped to the target.
     * @return bool
     */
    public function execute();
}
