<?php

namespace tests\Collections\Maps;

use DCP\Mapper\Collections\Maps\RuleMap;
use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\RuleCollection;
use tests\Stubs\Rules\RuleStub;

require_once __DIR__ . '/../../Stubs/Rules/RuleStub.php';

class RuleMapTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotSetWithNonRuleCollection()
    {
        $expectedMessage = '$value must be an instance of RuleCollection';
        $actualMessage = '';

        $exceptionThrown = false;

        $instance = new RuleMap();

        try {
            $instance->set('test', 'not a collection');
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCanSetAndGetValues()
    {
        $expectedValues = [
            'test' => new RuleCollection(),
            'test2' => new RuleCollection()
        ];
        $actualValues = [];

        $instance = new RuleMap();

        foreach ($expectedValues as $key => $value) {
            $instance->set($key, $value);

            $actualValues[$key] = $instance->get($key);
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testGettingNonExistentKeyWithoutDefaultReturnsNull()
    {
        $instance = new RuleMap();

        $result = $instance->get('non_existent', false);

        $this->assertNull($result);
    }

    public function testGettingNonExistentKeyWithDefaultReturnsRuleCollection()
    {
        $expectedResult = get_class(new RuleCollection());
        $actualResult = false;

        $instance = new RuleMap();

        $actualResult = $instance->get('non_existent');

        $this->assertInstanceOf($expectedResult, $actualResult);
    }

    public function testCannotAddWhenValueIsNonRule()
    {
        $expectedMessage = '$value must be an instance of DCP\Mapper\RuleInterface';
        $actualMessage = '';

        $exceptionThrown = false;

        $instance = new RuleMap();

        try {
            $instance->add('test', 'non_rule');
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCanAddToExistingKey()
    {
        $oldValues = [
            new RuleStub('test 1')
        ];

        $newValues = [
            new RuleStub('test 2')
        ];

        $expectedValues = array_merge($oldValues, $newValues);
        $actualValues = [];

        $collection = new RuleCollection();
        $instance = (new RuleMap())
            ->set('test', $collection)
        ;

        foreach ($oldValues as $oldValue) {
            $collection->add($oldValue);
        }

        foreach ($newValues as $newValue) {
            $instance->add('test', $newValue);
        }

        foreach ($instance->get('test') as $rule) {
            $actualValues[] = $rule;
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testCanAddToNewKey()
    {
        $expectedValues = [
            new RuleStub('test 1'),
            new RuleStub('test 2')
        ];
        $actualValues = [];

        $instance = new RuleMap();

        foreach ($expectedValues as $value) {
            $instance->add('test', $value);
        }

        foreach ($instance->get('test') as $rule) {
            $actualValues[] = $rule;
        }

        $this->assertEquals($expectedValues, $actualValues);
    }
}
