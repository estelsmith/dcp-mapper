<?php

namespace tests\Rules;

use DCP\Mapper\Rules\CallbackRule;

class CallbackRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testRuleWithTrueReturnsTrue()
    {
        $instance = new CallbackRule(function () { return true; });

        $this->assertTrue($instance->execute());
    }

    public function testRuleWithTruthyReturnsTrue()
    {
        $instance = new CallbackRule(function () { return 'test 123'; });

        $this->assertTrue($instance->execute());
    }

    public function testRuleWithFalseReturnsFalse()
    {
        $instance = new CallbackRule(function () { return false; });

        $this->assertFalse($instance->execute());
    }

    public function testWithFalseyReturnsFalse()
    {
        $instance = new CallbackRule(function () { return null; });

        $this->assertFalse($instance->execute());
    }
}
