<?php

namespace tests\Collections\Maps;

use DCP\Mapper\Collections\Maps\TransformerMap;
use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\TransformerCollection;
use tests\Stubs\Transformers\TransformerStub;

require_once __DIR__ . '/../../Stubs/Transformers/TransformerStub.php';

class TransformerMapTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotSetWithNonTransformerCollection()
    {
        $expectedMessage = '$value must be an instance of TransformerCollection';
        $actualMessage = '';

        $exceptionThrown = false;

        $instance = new TransformerMap();

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
            'test' => new TransformerCollection(),
            'test2' => new TransformerCollection()
        ];
        $actualValues = [];

        $instance = new TransformerMap();

        foreach ($expectedValues as $key => $value) {
            $instance->set($key, $value);

            $actualValues[$key] = $instance->get($key);
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testGettingNonExistentKeyWithoutDefaultReturnsNull()
    {
        $instance = new TransformerMap();

        $result = $instance->get('non_existent', false);

        $this->assertNull($result);
    }

    public function testGettingNonExistentKeyWithDefaultReturnsTransformerCollection()
    {
        $expectedResult = get_class(new TransformerCollection());
        $actualResult = false;

        $instance = new TransformerMap();

        $actualResult = $instance->get('non_existent');

        $this->assertInstanceOf($expectedResult, $actualResult);
    }

    public function testCannotAddWhenValueIsNonTransformer()
    {
        $expectedMessage = '$value must be an instance of TransformerInterface';
        $actualMessage = '';

        $exceptionThrown = false;

        $instance = new TransformerMap();

        try {
            $instance->add('test', 'non_transformer');
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
            new TransformerStub('test 1')
        ];

        $newValues = [
            new TransformerStub('test 2')
        ];

        $expectedValues = array_merge($oldValues, $newValues);
        $actualValues = [];

        $collection = new TransformerCollection();
        $instance = (new TransformerMap())
            ->set('test', $collection)
        ;

        foreach ($oldValues as $oldValue) {
            $collection->add($oldValue);
        }

        foreach ($newValues as $newValue) {
            $instance->add('test', $newValue);
        }

        foreach ($instance->get('test') as $transformer) {
            $actualValues[] = $transformer;
        }

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function testCanAddToNewKey()
    {
        $expectedValues = [
            new TransformerStub('test 1'),
            new TransformerStub('test 2')
        ];
        $actualValues = [];

        $instance = new TransformerMap();

        foreach ($expectedValues as $value) {
            $instance->add('test', $value);
        }

        foreach ($instance->get('test') as $transformer) {
            $actualValues[] = $transformer;
        }

        $this->assertEquals($expectedValues, $actualValues);
    }
}
