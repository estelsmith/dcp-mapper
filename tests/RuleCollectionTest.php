<?php

namespace tests;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\RuleCollection;
use DCP\Mapper\RuleInterface;
use tests\Stubs\Rules\RuleStub;

require 'Stubs/Rules/RuleStub.php';

class RuleCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotAddNonRuleToCollection()
    {
        $expectedMessage = '$rule must be an instance of RuleInterface';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new RuleCollection();

        try {
            $instance->add('Not a rule');
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCanAddRulesToCollection()
    {
        /** @var RuleInterface[] $data */
        $data = [
            new RuleStub(),
            new RuleStub()
        ];

        $expectedMatches = count($data);
        $actualMatches = 0;

        $instance = new RuleCollection();

        foreach ($data as $value) {
            $instance->add($value);
        }

        foreach ($instance as $key => $value) {
            if ($data[$key] === $value) {
                ++$actualMatches;
            }
        }

        $this->assertEquals($expectedMatches, $actualMatches);
    }
}
