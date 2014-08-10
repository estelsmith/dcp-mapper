<?php

namespace tests;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\TransformerInterface;
use DCP\Mapper\TransformerMap;
use tests\Stubs\Transformers\TransformerStub;

require_once 'Stubs/Transformers/TransformerStub.php';

class TransformerMapTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotAddWithNonStringField()
    {
        $expectedMessage = '$field must be a string';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new TransformerMap();

        try {
            $instance->add(null, new TransformerStub());
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCannotAddWithNonTransformer()
    {
        $expectedMessage = 'Argument 2 passed to DCP\Mapper\TransformerMap::add() must implement interface' .
                           ' DCP\Mapper\TransformerInterface';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new TransformerMap();

        try {
            $instance->add('test', 'not a transformer');
        } catch (\Exception $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertContains($expectedMessage, $actualMessage);
    }

    public function testRetrievingKeysWhileEmptyReturnsEmptyArray()
    {
        $instance = new TransformerMap();

        $this->assertEmpty($instance->getKeys());
    }

    public function testCanRetrieveKeys()
    {
        /** @var TransformerInterface[] $data */
        $data = [
            'test' => new TransformerStub(),
            'ing' => new TransformerStub()
        ];

        $expectedKeys = array_keys($data);
        $actualKeys = [];

        $instance = new TransformerMap();

        foreach ($data as $field => $transformer) {
            $instance->add($field, $transformer);
        }

        $actualKeys = $instance->getKeys();

        $this->assertEquals($expectedKeys, $actualKeys);
    }

    public function testCannotRetrieveTransformersWithInvalidKey()
    {
        /** @var TransformerInterface[] $data */
        $data = [
            'test' => new TransformerStub(),
            'ing' => new TransformerStub()
        ];

        $instance = new TransformerMap();

        foreach ($data as $field => $transformer) {
            $instance->add($field, $transformer);
        }

        $transformers = $instance->getTransformers('not_existing')->toArray();

        $this->assertEmpty($transformers);
    }

    public function testCanAddAndRetrieveTransformersWithValidData()
    {
        $data = [
            'test' => [
                new TransformerStub()
            ],
            'ing' => [
                new TransformerStub(),
                new TransformerStub()
            ]
        ];

        $expectedMatches = [];
        $actualMatches = [];

        $instance = new TransformerMap();

        foreach ($data as $key => $value) {
            $expectedMatches[$key] = count($value);

            foreach ($value as $transformer) {
                $instance->add($key, $transformer);
            }
        }

        foreach (array_keys($data) as $key) {
            $transformers = $instance->getTransformers($key)->toArray();

            if (!array_key_exists($key, $actualMatches)) {
                $actualMatches[$key] = 0;
            }

            if ($data[$key] === $transformers) {
                $actualMatches[$key] += count($transformers);
            }
        }

        $this->assertEquals($expectedMatches, $actualMatches);
    }
}
