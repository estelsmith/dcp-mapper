<?php

namespace tests;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\RuleInterface;
use DCP\Mapper\RuleMap;
use tests\Stubs\Rules\RuleStub;

require_once 'Stubs/Rules/RuleStub.php';

class RuleMapTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotAddWithNonStringField()
    {
        $expectedMessage = '$field must be a string';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new RuleMap();

        try {
            $instance->add(null, new RuleStub());
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCannotAddWithNonRule()
    {
        $expectedMessage = 'Argument 2 passed to DCP\Mapper\RuleMap::add() must implement interface DCP\Mapper\RuleInterface';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new RuleMap();

        try {
            $instance->add('test', 'not a rule');
        } catch (\Exception $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertContains($expectedMessage, $actualMessage);
    }

    public function testRetrievingKeysWhileEmptyReturnsEmptyArray()
    {
        $instance = new RuleMap();

        $this->assertEmpty($instance->getKeys());
    }

    public function testCanRetrieveKeys()
    {
        /** @var RuleInterface[] $data */
        $data = [
            'test' => new RuleStub(),
            'ing' => new RuleStub()
        ];

        $expectedKeys = array_keys($data);
        $actualKeys = [];

        $instance = new RuleMap();

        foreach ($data as $field => $rule) {
            $instance->add($field, $rule);
        }

        $actualKeys = $instance->getKeys();

        $this->assertEquals($expectedKeys, $actualKeys);
    }

    public function testCannotRetrieveRulesWithInvalidKey()
    {
        /** @var RuleInterface[] $data */
        $data = [
            'test' => new RuleStub(),
            'ing' => new RuleStub()
        ];

        $instance = new RuleMap();

        foreach ($data as $field => $rule) {
            $instance->add($field, $rule);
        }

        $rules = $instance->getRules('not_existing')->toArray();

        $this->assertEmpty($rules);
    }

    public function testCanAddAndRetrieveRulesWithValidData()
    {
        $data = [
            'test' => [
                new RuleStub()
            ],
            'ing' => [
                new RuleStub(),
                new RuleStub()
            ]
        ];

        $expectedMatches = [];
        $actualMatches = [];

        $instance = new RuleMap();

        foreach ($data as $key => $value) {
            $expectedMatches[$key] = count($value);

            foreach ($value as $rule) {
                $instance->add($key, $rule);
            }
        }

        foreach (array_keys($data) as $key) {
            $rules = $instance->getRules($key)->toArray();

            if (!array_key_exists($key, $actualMatches)) {
                $actualMatches[$key] = 0;
            }

            if ($data[$key] === $rules) {
                $actualMatches[$key] += count($rules);
            }
        }

        $this->assertEquals($expectedMatches, $actualMatches);
    }
}
