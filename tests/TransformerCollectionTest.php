<?php

namespace tests;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\TransformerCollection;
use DCP\Mapper\TransformerInterface;
use tests\Stubs\Transformers\TransformerStub;

require_once 'Stubs/Transformers/TransformerStub.php';

class TransformerCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotAddNonTransformerToCollection()
    {
        $expectedMessage = '$transformer must be an instance of TransformerInterface';
        $actualMessage = '';
        $exceptionThrown = false;

        $instance = new TransformerCollection();

        try {
            $instance->add('Not a transformer');
        } catch (InvalidArgumentException $e) {
            $exceptionThrown = true;
            $actualMessage = $e->getMessage();
        }

        $this->assertTrue($exceptionThrown);
        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testCanAddTransformersToCollection()
    {
        /** @var TransformerInterface[] $data */
        $data = [
            new TransformerStub(),
            new TransformerStub()
        ];

        $expectedMatches = count($data);
        $actualMatches = 0;

        $instance = new TransformerCollection();

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

    public function testCanGetEmptyCollectionAsEmptyArray()
    {
        $instance = new TransformerCollection();

        $this->assertEmpty($instance->toArray());
    }

    public function testCanGetCollectionAsArray()
    {
        $expectedData = [
            new TransformerStub(),
            new TransformerStub()
        ];

        $actualData = null;

        $instance = new TransformerCollection();

        foreach ($expectedData as $item) {
            $instance->add($item);
        }

        $actualData = $instance->toArray();

        $this->assertEquals($expectedData, $actualData);
    }
}
