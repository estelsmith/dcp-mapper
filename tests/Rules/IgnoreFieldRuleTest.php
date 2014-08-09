<?php

namespace tests\Rules;

use DCP\Mapper\Rules\IgnoreFieldRule;

class IgnoreFieldRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testRuleReturnsFalse()
    {
        $instance = new IgnoreFieldRule();

        $this->assertFalse($instance->execute());
    }
}
