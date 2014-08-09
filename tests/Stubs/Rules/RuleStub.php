<?php

namespace tests\Stubs\Rules;

use DCP\Mapper\RuleInterface;

/**
 * @codeCoverageIgnore
 */
class RuleStub implements RuleInterface
{
    private $result;

    public function __construct($result = true)
    {
        $this->result = $result;
    }

    public function execute()
    {
        return $this->result;
    }
}
