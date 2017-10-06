<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArraySetComputeTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArraySetComputeTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArraySetComputeTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArraySetComputeTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testDiff()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];

        $result = $trait->diffByKey(['foo1' => 0, 'foo2' => 0]);
        $this->assertEquals(['bar' => 3], $result->toArray());

        $compareFunc = function ($key1, $key2) {
            return (substr($key1, 0, 3) == substr($key2, 0, 3)) ? 0 : -1;
        };
        $result = $trait->diffByKeyCompare($compareFunc, ['foo' => 0]);
        $this->assertEquals(['bar' => 3], $result->toArray());


        $trait->elements = ['foo1', 'foo2', 'bar'];

        $result = $trait->diffByValue(['foo1', 'foo2']);
        $this->assertEquals([2 => 'bar'], $result->toArray());

        $compareFunc = function ($val1, $val2) {
            return (substr($val1, 0, 3) == substr($val2, 0, 3)) ? 0 : -1;
        };
        $result = $trait->diffByValueCompare($compareFunc, ['foo']);
        $this->assertEquals([2 => 'bar'], $result->toArray());
    }


    public function testIntersect()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];

        $result = $trait->intersectByKey(['foo' => 0, 'bar' => 0]);
        $this->assertEquals(['bar' => 3], $result->toArray());

        // Seems {@link array_intersect_uKey()} do internal key compare on
        // source and compare to array first, and result array NEVER exceed
        // count of compare to array, so few compare to array elements may
        // cause incorrect test result.
        $compareFunc = function ($key1, $key2) {
            return (substr($key1, 0, 3) == substr($key2, 0, 3)) ? 0 : -1;
        };
        $result = $trait->intersectByKeyCompare(
            $compareFunc,
            ['foo3' => 0, 'foo4' => 0]
        );
        $this->assertEquals(['foo1' => 1, 'foo2' => 2], $result->toArray());


        $trait->elements = ['foo1', 'foo2', 'bar'];

        $result = $trait->intersectByValue(['foo', 'bar']);
        $this->assertEquals([2 => 'bar'], $result->toArray());

        $compareFunc = function ($val1, $val2) {
            return (substr($val1, 0, 3) == substr($val2, 0, 3)) ? 0 : -1;
        };
        $result = $trait->intersectByValueCompare($compareFunc, ['foo']);
        $this->assertEquals([0 => 'foo1', 1 => 'foo2'], $result->toArray());
    }


    public function testMergeUnion()
    {
        $trait = $this->buildMock();

        // Key foo2 will be overwritten
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $result = $trait->merge(['foo2' => 22, 'foo3' => 4]);
        $this->assertEquals(
            ['foo1' => 1, 'foo2' => 22, 'bar' => 3, 'foo3' => 4],
            $result->elements
        );

        // Key foo2 will not be overwritten
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $result = $trait->union(['foo2' => 22, 'foo3' => 4]);
        $this->assertEquals(
            ['foo1' => 1, 'foo2' => 2, 'bar' => 3, 'foo3' => 4],
            $result->elements
        );
    }


    public function testSlice()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];

        $result = $trait->slice(2, 1);
        $this->assertEquals(['bar' => 3], $result->toArray());
    }


    public function testSplice()
    {
        $trait = $this->buildMock();

        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $result = $trait->splice(2, 1);
        $this->assertEquals(['bar' => 3], $result->toArray());
        $this->assertEquals(['foo1' => 1, 'foo2' => 2], $trait->elements);


        // Splice to end
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        $result = $trait->splice(1);
        $this->assertEquals(['foo2' => 2, 'bar' => 3], $result->toArray());
        $this->assertEquals(['foo1' => 1], $trait->elements);


        // With replacement
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];
        // Should overwritten foo1 and bar, yes its insert
        $result =
            $trait->splice(1, 0, ['foo1' => 11, 'foo4' => 4, 'bar' => 33]);
        $this->assertEquals([], $result->toArray());
        $this->assertEquals(
            var_export(
                ['foo1' => 11, 'foo4' => 4, 'bar' => 33, 'foo2' => 2],
                true
            ),
            var_export($trait->elements, true)
        );
    }


    public function testSplit()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo1' => 1, 'foo2' => 2, 'bar' => 3];

        $predicate = function ($element) {
            return $element > 2;
        };
        $result = $trait->split($predicate);
        $this->assertEquals(['bar' => 3], $result[0]->toArray());
        $this->assertEquals(['foo1' => 1, 'foo2' => 2], $result[1]->toArray());
        // Original collection is un-touched
        $this->assertEquals(3, count($trait->elements));
    }
}
