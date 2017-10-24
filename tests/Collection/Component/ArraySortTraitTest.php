<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArraySortTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArraySortTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArraySortTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArraySortTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testReverseShuffleUnique()
    {
        $trait = $this->buildMock();

        $trait->elements = ['foo', 'foo', 'bar'];
        $this->assertEquals(
            var_export([2 => 'bar', 1 => 'foo', 0 => 'foo'], true),
            var_export($trait->reverse()->elements, true)
        );


        $trait->elements = ['foo', 'foo', 'bar'];
        $this->assertEquals(
            var_export(['foo', 2 => 'bar'], true),
            var_export($trait->unique()->elements, true)
        );

        $trait->elements = ['foo', 'foo', 'bar'];
        $trait->shuffle();
        $this->assertEquals(3, count($trait->elements));
    }


    public function testSortByKey()
    {
        $trait = $this->buildMock();

        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $this->assertEquals(
            var_export(['bar' => 3, 'foo1' => 1, 'foo2' => 2], true),
            var_export($trait->sortByKey()->elements, true)
        );

        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $this->assertEquals(
            var_export(['foo2' => 2, 'foo1' => 1, 'bar' => 3], true),
            var_export($trait->sortByKeyReversed()->elements, true)
        );

        $compareFunc = function ($val1, $val2) {
            $val1 = intval(preg_replace('/[a-z]/', '', $val1));
            $val2 = intval(preg_replace('/[a-z]/', '', $val2));

            $val1 = intval($val1);
            $val2 = intval($val2);

            if ($val1 == $val2) {
                return 0;
            } else {
                return $val1 < $val2 ? -1 : 1;
            }
        };
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $this->assertEquals(
            var_export(['bar' => 3, 'foo1' => 1, 'foo2' => 2], true),
            var_export($trait->sortByKeyCompare($compareFunc)->elements, true)
        );
    }


    public function testSortByValue()
    {
        $trait = $this->buildMock();

        // Keys are reserved when sort

        $trait->elements = ['foo1', 'foo2', 'bar'];
        $this->assertEquals(
            var_export([2 => 'bar', 0 => 'foo1', 1 => 'foo2'], true),
            var_export($trait->sortByValue()->elements, true)
        );

        $trait->elements = ['foo1', 'foo2', 'bar'];
        $this->assertEquals(
            var_export([1 => 'foo2', 0 => 'foo1', 2 => 'bar'], true),
            var_export($trait->sortByValueReversed()->elements, true)
        );

        $compareFunc = function ($val1, $val2) {
            $val1 = intval(preg_replace('/[a-z]/', '', $val1));
            $val2 = intval(preg_replace('/[a-z]/', '', $val2));

            $val1 = intval($val1);
            $val2 = intval($val2);

            if ($val1 == $val2) {
                return 0;
            } else {
                return $val1 < $val2 ? -1 : 1;
            }
        };
        $trait->elements = ['foo1', 'foo2', 'bar'];
        $this->assertEquals(
            var_export([2 => 'bar', 0 => 'foo1', 1 => 'foo2'], true),
            var_export(
                $trait->sortByValueCompare($compareFunc)->elements,
                true
            )
        );
    }
}
