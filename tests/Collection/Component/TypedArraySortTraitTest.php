<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedArraySortTrait;
use FwolfTest\Common\Collection\TypedCollectionTestDummy;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedArraySortTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedArraySortTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(TypedArraySortTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testReverseShuffleUnique()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy('foo'),
            new TypedElementDummy('foo'),
            new TypedElementDummy('bar'),
        ]);

        // Duplicate identity foo should be overwritten by later value
        $this->assertEquals(2, $trait->count());

        // Already unique, this does nothing
        $trait->unique();
        $this->assertEquals(2, $trait->count());


        $trait->shuffle();
        $this->assertEquals(2, $trait->count());
    }


    public function testSortByKey()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy('foo1'),
            new TypedElementDummy('foo2'),
            new TypedElementDummy('bar'),
        ]);

        $this->assertEquals(
            var_export(['bar', 'foo1', 'foo2'], true),
            var_export($trait->sortByKey()->getKeys(), true)
        );

        $this->assertEquals(
            var_export(['foo2', 'foo1', 'bar'], true),
            var_export($trait->sortByKeyReversed()->getKeys(), true)
        );


        $compareFunc = function ($key1, $key2) {
            $key1 = intval(preg_replace('/[a-z]/', '', $key1));
            $key2 = intval(preg_replace('/[a-z]/', '', $key2));

            if ($key1 == $key2) {
                return 0;
            } else {
                return $key1 < $key2 ? -1 : 1;
            }
        };
        $keys = $trait->sortByKeyCompare($compareFunc)->getKeys();
        $this->assertEquals(
            var_export(['bar', 'foo1', 'foo2'], true),
            var_export($keys, true)
        );
    }


    public function testSortByValue()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy('foo1'),
            new TypedElementDummy('foo2'),
            new TypedElementDummy('bar'),
        ]);

        $this->assertEquals(
            var_export(['bar', 'foo1', 'foo2'], true),
            var_export($trait->sortByValue()->getKeys(), true)
        );

        $this->assertEquals(
            var_export(['foo2', 'foo1', 'bar'], true),
            var_export($trait->sortByValueReversed()->getKeys(), true)
        );


        $compareFunc = function (
            TypedElementDummy $val1,
            TypedElementDummy $val2
        ) {
            $key1 = $val1->getIdentity();
            $key2 = $val2->getIdentity();

            $key1 = intval(preg_replace('/[a-z]/', '', $key1));
            $key2 = intval(preg_replace('/[a-z]/', '', $key2));

            if ($key1 == $key2) {
                return 0;
            } else {
                return $key1 < $key2 ? -1 : 1;
            }
        };
        $keys = $trait->sortByValueCompare($compareFunc)->getKeys();
        $this->assertEquals(
            var_export(['bar', 'foo1', 'foo2'], true),
            var_export($keys, true)
        );
    }
}
