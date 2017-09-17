<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArrayTravelTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArrayTravelTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArrayTravelTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArrayTravelTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testEach()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo', 'bar'];

        $output = '';
        $closure = function ($key, $val) use (&$output) {
            $output .= "Key: $key, Value: $val\n";
        };
        $trait->each($closure);
        $expected = "Key: 0, Value: foo\nKey: 1, Value: bar\n";
        $this->assertEquals($expected, $output);
    }


    public function testMap()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo', 'bar'];

        $closure = function ($element) {
            return "i" . ucfirst($element);
        };
        $result = $trait->map($closure);
        $this->assertEquals(['iFoo', 'iBar'], $result->toArray());
    }


    public function testWalk()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo', 'bar'];

        $output = '';
        $closure = function ($element) use (&$output) {
            $output .= "Value: $element\n";
        };
        $trait->walk($closure);
        $expected = "Value: foo\nValue: bar\n";
        $this->assertEquals($expected, $output);
    }
}
