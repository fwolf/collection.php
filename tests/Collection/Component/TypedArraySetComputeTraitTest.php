<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedArraySetComputeTrait;
use FwolfTest\Common\Collection\TypedCollectionTestDummy;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017, 2021 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedArraySetComputeTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedArraySetComputeTrait
     */
    protected function buildMock(array $methods = null)
    {
        $methods = is_null($methods) ? [] : $methods;
        $methods = array_merge($methods, [
            'assertAllowedType',
            'assertAllowedTypes',
            'getElementIdentity',
        ]);

        $mock = $this->getMockBuilder(TypedArraySetComputeTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        {
            $mock->elements = [];
            $mock->allowedType = 'stdClass';
        }

        $mock->method('getElementIdentity')
            ->willReturnCallback(function ($element) {
                return call_user_func([$element, 'getIdentity']);
            });

        return $mock;
    }


    public function testDiff()
    {
        $element1 = new TypedElementDummy('foo1');
        $element2 = new TypedElementDummy('foo2');
        $element3 = new TypedElementDummy('bar1');
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3]
        );


        $collection = new TypedCollectionTestDummy([$element1, $element2]);
        $result = $trait->diffByKey($collection->toArray());
        $this->assertEquals(['bar1'], $result->getKeys());

        $compareFunc = function ($key1, $key2) {
            return (substr($key1, 0, 3) == substr($key2, 0, 3)) ? 0 : -1;
        };
        $collection = new TypedCollectionTestDummy([$element1]);
        $result =
            $trait->diffByKeyCompare($compareFunc, $collection->toArray());
        $this->assertEquals(['bar1'], $result->getKeys());


        $collection = new TypedCollectionTestDummy([$element1, $element2]);
        $result = $trait->diffByValue($collection->toArray());
        $this->assertEquals(['bar1'], $result->getKeys());

        $compareFunc = function (
            TypedElementDummy $val1,
            TypedElementDummy $val2
        ) {
            $key1 = $val1->getIdentity();
            $key2 = $val2->getIdentity();

            return (substr($key1, 0, 3) == substr($key2, 0, 3)) ? 0 : -1;
        };
        $collection = new TypedCollectionTestDummy([$element1]);
        $result = $trait->diffByValueCompare(
            $compareFunc,
            $collection->toArray()
        );
        $this->assertEquals(['bar1'], $result->getKeys());
    }


    public function testIntersect()
    {
        $element1 = new TypedElementDummy('foo1');
        $element2 = new TypedElementDummy('foo2');
        $element3 = new TypedElementDummy('bar1');
        $element4 = new TypedElementDummy('bar2');
        $element5 = new TypedElementDummy('foo3');
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3, $element4]
        );


        $collection = new TypedCollectionTestDummy([$element2, $element3]);
        $result = $trait->intersectByKey($collection->toArray());
        $this->assertEquals(['foo2', 'bar1'], $result->getKeys());

        // Seems {@link array_intersect_uKey()} do internal key compare on
        // source and compare to array first, and result array NEVER exceed
        // count of compare to array, so few compare to array elements may
        // cause incorrect test result.
        $compareFunc = function ($key1, $key2) {
            // {@link array_intersect_uKey()} will sort source array with user
            // defined func first, when compare with against the sort info
            // will be used to optimize.
            return strncmp($key1, $key2, 4);
        };
        $collection = new TypedCollectionTestDummy(
            [$element2, $element3, $element5]
        );
        $result = $trait->intersectByKeyCompare(
            $compareFunc,
            $collection->toArray()
        );
        $this->assertEquals(['foo2', 'bar1'], $result->getKeys());


        $collection = new TypedCollectionTestDummy([$element1, $element3]);
        $result = $trait->intersectByValue($collection->toArray());
        $this->assertEquals(['foo1', 'bar1'], $result->getKeys());

        $compareFunc = function (
            TypedElementDummy $elm1,
            TypedElementDummy $elm2
        ) {
            $val1 = $elm1->getIdentity();
            $val2 = $elm2->getIdentity();

            return strncmp($val1, $val2, 4);
        };
        $collection = new TypedCollectionTestDummy(
            [$element5, $element4, $element3]
        );
        $result = $trait->intersectByValueCompare(
            $compareFunc,
            $collection->toArray()
        );
        // As sort reason above, result array order maybe a little chaos, do
        // not rely on it.
        $this->assertEquals(['bar1', 'bar2'], $result->getKeys());
    }


    public function testMergeUnion()
    {
        $element1 = new TypedElementDummy('foo1');
        $element2 = new TypedElementDummy('foo2');
        $element2->num = 42;
        $element3 = new TypedElementDummy('foo3');
        $element22 = new TypedElementDummy('foo2');
        $element22->num = 4242;
        $collection = new TypedCollectionTestDummy([$element3, $element22]);


        // Key foo2 will be overwritten
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2]
        );
        $result = $trait->merge($collection->toArray());
        $this->assertEquals(['foo1', 'foo2', 'foo3'], $result->getKeys());
        $this->assertEquals(4242, $result->get('foo2')->num);


        // Key foo2 will not be overwritten
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2]
        );
        $result = $trait->union($collection->toArray());
        $this->assertEquals(['foo1', 'foo2', 'foo3'], $result->getKeys());
        $this->assertEquals(42, $result->get('foo2')->num);
    }


    public function testSlice()
    {
        $element1 = new TypedElementDummy('foo1');
        $element2 = new TypedElementDummy('foo2');
        $element3 = new TypedElementDummy('bar1');
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3]
        );

        $result = $trait->slice(2, 1);
        $this->assertEquals(['bar1'], $result->getKeys());
    }


    public function testSplice()
    {
        $element1 = new TypedElementDummy('foo1');
        $element1->num = 1;
        $element2 = new TypedElementDummy('foo2');
        $element3 = new TypedElementDummy('bar1');
        $element3->num = 3;
        $element4 = new TypedElementDummy('bar2');
        $element11 = new TypedElementDummy('foo1');
        $element11->num = 11;
        $element33 = new TypedElementDummy('bar1');
        $element33->num = 33;
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3]
        );

        $result = $trait->splice(2, 1);
        $this->assertEquals(['bar1'], $result->getKeys());
        $this->assertEquals(['foo1', 'foo2'], $trait->getKeys());


        // Splice to end
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3]
        );
        $result = $trait->splice(1);
        $this->assertEquals(['foo2', 'bar1'], $result->getKeys());
        $this->assertEquals(['foo1'], $trait->getKeys());


        // With replacement
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3]   // foo1, foo2, bar1
        );
        $collection = new TypedCollectionTestDummy(
            [$element11, $element4, $element33] // foo1, bar2, bar1
        );
        // Should overwritten foo1 and bar1, yes its insert
        $result = $trait->splice(1, 0, $collection->toArray());
        $this->assertEquals(0, $result->count());
        // 'bar1' from outer is head of 'foo2' as its from overwritten
        $this->assertEquals(
            var_export(
                ['foo1', 'bar2', 'bar1', 'foo2'],
                true
            ),
            var_export($trait->getKeys(), true)
        );
    }


    public function testSplit()
    {
        $element1 = new TypedElementDummy('foo1');
        $element2 = new TypedElementDummy('foo2');
        $element3 = new TypedElementDummy('bar1');
        $trait = new TypedCollectionTestDummy(
            [$element1, $element2, $element3]
        );

        $predicate = function (TypedElementDummy $element) {
            $identity = $element->getIdentity();

            return intval(substr($identity, 3, 1)) > 1;
        };
        $result = $trait->split($predicate);
        $this->assertEquals(['foo2'], $result[0]->getKeys());
        $this->assertEquals(['foo1', 'bar1'], $result[1]->getKeys());
        // Original collection is un-touched
        $this->assertEquals(3, $trait->count());
    }
}
