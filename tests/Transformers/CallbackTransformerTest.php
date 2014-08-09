<?php

namespace tests\Transformers;

use DCP\Mapper\Transformers\CallbackTransformer;

class CallbackTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testTransformWithLowercaseReturnsLowercaseValues()
    {
        $data = [
            'TEST 1',
            'TeSt 2',
            'test 3'
        ];

        $expectedData = array_map(function ($value) { return strtolower($value); }, $data);
        $actualData = [];

        $instance = new CallbackTransformer(function ($value) {
            return strtolower($value);
        });

        foreach ($data as $value) {
            $actualData[] = $instance->transform($value);
        }

        $this->assertEquals($expectedData, $actualData);
    }

    public function testTransformWithUppercaseReturnsUppercaseValues()
    {
        $data = [
            'TEST 1',
            'TeSt 2',
            'test 3'
        ];

        $expectedData = array_map(function ($value) { return strtoupper($value); }, $data);
        $actualData = [];

        $instance = new CallbackTransformer(function ($value) {
            return strtoupper($value);
        });

        foreach ($data as $value) {
            $actualData[] = $instance->transform($value);
        }

        $this->assertEquals($expectedData, $actualData);
    }
}
