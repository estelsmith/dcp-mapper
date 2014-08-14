<?php

namespace tests\Collections\Maps;

use DCP\Mapper\Collections\Maps\Map;
use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Exception\OutOfBoundsException;

class MapTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotSetWhenKeyIsNonStringOrInteger()
    {
        $expectedMessage = '$key must be a string or integer';
        $actualMessage = '';

        $exceptionThrown = false;

        $instance = new Map();

        try {
            $instance->set(true, 'test');
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCannotGetNonExistentKey()
    {
        $expectedMessage = 'The key "test" does not exist';
        $actualMessage = '';

        $exceptionThrown = false;

        $instance = new Map();

        try {
            $instance->get('test');
        } catch (OutOfBoundsException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCanSetAndGetValuesWithStringKeys()
    {
        $expectedValues = [
            'test1' => 'this is a test',
            'test2' => 'this is another test'
        ];
        $actualValues = [];

        $instance = new Map();

        foreach ($expectedValues as $key => $value) {
            $instance->set($key, $value);

            $actualValues[$key] = $instance->get($key);
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testCanSetAndGetValuesWithIntegerKeys()
    {
        $expectedValues = [
            5 => 'this is a test',
            8 => 'this is another test'
        ];
        $actualValues = [];

        $instance = new Map();

        foreach ($expectedValues as $key => $value) {
            $instance->set($key, $value);

            $actualValues[$key] = $instance->get($key);
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testHasReturnsFalseWhenUsingNonExistentKey()
    {
        $expectedResult = false;
        $actualResult = null;

        $instance = new Map();

        $actualResult = $instance->has('test');

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testHasReturnsTrueWhenUsingValidKey()
    {
        $expectedResult = true;
        $actualResult = null;

        $instance = new Map();
        $instance->set('test', 'testing');

        $actualResult = $instance->has('test');

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testGettingKeysWhileEmptyReturnsEmptyArray()
    {
        $expectedResult = [];
        $actualResult = null;

        $instance = new Map();

        $actualResult = $instance->getKeys();

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testCanGetKeys()
    {
        $expectedResult = [
            'test',
            'ing',
            'yay'
        ];
        $actualResult = null;

        $instance = new Map();

        foreach ($expectedResult as $value) {
            $instance->set($value, 'test');
        }

        $actualResult = $instance->getKeys();

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testCanGetIterator()
    {
        $expectedValues = [
            'test' => 'this is a test',
            'test2' => 'this is another test'
        ];
        $actualValues = [];

        $instance = new Map();

        foreach ($expectedValues as $key => $value) {
            $instance->set($key, $value);
        }

        $iterator = $instance->getIterator();
        $this->assertInstanceOf('\Traversable', $iterator);

        foreach ($iterator as $key => $value) {
            $actualValues[$key] = $value;
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testCanIterate()
    {
        $expectedValues = [
            'test' => 'this is a test',
            'test2' => 'this is another test'
        ];
        $actualValues = [];

        $instance = new Map();

        foreach ($expectedValues as $key => $value) {
            $instance->set($key, $value);
        }

        foreach ($instance as $key => $value) {
            $actualValues[$key] = $value;
        }

        $this->assertEquals($expectedValues, $actualValues);
    }
}
