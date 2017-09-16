<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArraySearchTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArraySearchTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArraySearchTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArraySearchTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testEvery()
    {
        $trait = $this->buildMock();
        $trait->elements = [1, 2, 3, 4, 5];

        $predicate = function ($element) {
            return $element >= 3;
        };
        $this->assertFalse($trait->every($predicate));

        $predicate = function ($element) {
            return $element >= 0;
        };
        $this->assertTrue($trait->every($predicate));
    }


    public function testExists()
    {
        $trait = $this->buildMock();
        $trait->elements = [1, 2, 3, 4, 5];

        $predicate = function ($element) {
            return $element >= 6;
        };
        $this->assertFalse($trait->exists($predicate));

        $predicate = function ($element) {
            return $element >= 4;
        };
        $this->assertTrue($trait->exists($predicate));
    }


    public function testFilter()
    {
        $trait = $this->buildMock();
        $trait->elements = [1, 2, 3, 4, 5];

        $predicate = function ($element) {
            return $element >= 3;
        };
        // Old array key are reserved
        $this->assertEquals(
            [2 => 3, 3 => 4, 4 => 5],
            $trait->filter($predicate)->elements
        );
    }


    public function testHasElementOrKey()
    {
        $trait = $this->buildMock();
        $trait->elements = [1, 2, 3, 4, 5];

        $this->assertTrue($trait->hasElement(4));
        $this->assertFalse($trait->hasElement(6));

        $this->assertTrue($trait->hasKey(4));
        $this->assertFalse($trait->hasKey(6));
    }


    public function testMatching()
    {
        $trait = $this->buildMock();
        $trait->elements = [1, 2, 3, 4, 5];

        $predicate = function ($element) {
            return $element >= 3;
        };
        // Matching result will have new array keys
        $this->assertEquals(
            [3, 4, 5],
            $trait->matching($predicate)->getValues()
        );
    }
}
