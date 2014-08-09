<?php

namespace tests;

use tests\Stubs\CollectionStub;

require_once 'Stubs/CollectionStub.php';

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanIterateCollection()
    {
        $data = [
            'test value 1',
            'test value 2'
        ];

        $expectedMatches = count($data);
        $actualMatches = 0;

        $instance = new CollectionStub($data);

        foreach ($instance as $key => $item) {
            if ($data[$key] === $item) {
                ++$actualMatches;
            }
        }

        $this->assertEquals($expectedMatches, $actualMatches);
    }

    public function testCanAddValuesToCollection()
    {
        $data = [
            'another test 1',
            'another test 2'
        ];

        $expectedMatches = count($data);
        $actualMatches = 0;

        $instance = new CollectionStub();

        foreach ($data as $item) {
            $instance->add($item);
        }

        foreach ($instance as $key => $item) {
            if ($data[$key] === $item) {
                ++$actualMatches;
            }
        }

        $this->assertEquals($expectedMatches, $actualMatches);
    }

    public function testCanReturnEmptyCollectionAsEmptyArray()
    {
        $instance = new CollectionStub();

        $this->assertEmpty($instance->toArray());
    }

    public function testCanGetCollectionAsArray()
    {
        $expectedData = [
            'another test 1',
            'another test 2'
        ];

        $actualData = null;

        $instance = new CollectionStub();

        foreach ($expectedData as $item) {
            $instance->add($item);
        }

        $actualData = $instance->toArray();

        $this->assertEquals($expectedData, $actualData);
    }
}
