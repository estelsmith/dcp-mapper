<?php

namespace tests;

use DCP\Mapper\Collections\Maps\TransformerMap;
use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\ObjectMapper;
use DCP\Mapper\RuleMap;
use DCP\Mapper\Rules\IgnoreFieldRule;
use DCP\Mapper\Transformers\CallbackTransformer;
use tests\Stubs\MapperSourceStub;
use tests\Stubs\MapperTargetStub;

require_once 'Stubs/MapperSourceStub.php';
require_once 'Stubs/MapperTargetStub.php';

class ObjectMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotMapWithNonObjectSource()
    {
        $expectedMessage = '$source must be an object';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new ObjectMapper(new RuleMap(), new TransformerMap());

        try {
            $instance->map('not an object', new \stdClass());
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCannotMapWithNonObjectTarget()
    {
        $expectedMessage = '$target must be an object';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new ObjectMapper(new RuleMap(), new TransformerMap());

        try {
            $instance->map(new \stdClass(), 'not an object');
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCanMapObjectsWithEmptyRulesAndEmptyTransformers()
    {
        $source = (new MapperSourceStub())
            ->setTestField1('test 1')
            ->setTestField2('test 2')
        ;

        $target = new MapperTargetStub();

        $instance = new ObjectMapper(new RuleMap(), new TransformerMap());

        /** @var MapperTargetStub $result */
        $result = $instance->map($source, $target);

        $this->assertEquals('test 1', $result->getTestField1());
        $this->assertEquals('test 2', $result->getTestField2());
    }

    public function testCannotMapFieldWhenTargetSetterMissing()
    {
        $source = (new MapperSourceStub())
            ->setTestField1('test 1')
            ->setTestField2('test 2')
            ->setTestField4('test 3')
        ;

        $target = new MapperTargetStub();

        $instance = new ObjectMapper(new RuleMap(), new TransformerMap());

        /** @var MapperTargetStub $result */
        $result = $instance->map($source, $target);

        $this->assertEquals('test 1', $result->getTestField1());
        $this->assertEquals('test 2', $result->getTestField2());
        $this->assertNull($result->getTestField4());
    }

    public function testCanStopFieldsBeingMappedWithRules()
    {
        $source = (new MapperSourceStub())
            ->setTestField1('test 1')
            ->setTestField2('test 2')
            ->setTestField3('test 3')
        ;

        $target = new MapperTargetStub();

        $ruleMap = (new RuleMap())
            ->add('testField1', new IgnoreFieldRule())
            ->add('testField3', new IgnoreFieldRule())
        ;

        $instance = new ObjectMapper($ruleMap, new TransformerMap());

        /** @var MapperTargetStub $result */
        $result = $instance->map($source, $target);

        $this->assertNull($result->getTestField1());
        $this->assertEquals('test 2', $result->getTestField2());
        $this->assertNull($result->getTestField3());
    }

    public function testCanTransformMappedFields()
    {
        $source = (new MapperSourceStub())
            ->setTestField1('test 1')
            ->setTestField2('test 2')
            ->setTestField3('test 3')
        ;

        $target = new MapperTargetStub();

        $transformerMap = (new TransformerMap())
            ->add('testField1', new CallbackTransformer(function ($value) { return strtoupper($value); }))
            ->add('testField2', new CallbackTransformer(function ($value) { return ucfirst($value); }))
        ;

        $instance = new ObjectMapper(new RuleMap(), $transformerMap);

        /** @var MapperTargetStub $result */
        $result = $instance->map($source, $target);

        $this->assertEquals('TEST 1', $result->getTestField1());
        $this->assertEquals('Test 2', $result->getTestField2());
        $this->assertEquals('test 3', $result->getTestField3());
    }
}
