<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArrayAccessorTrait;
use Fwolf\Common\Collection\Exception\ExceedCollectionSizeException;
use Fwolf\Common\Collection\Exception\KeyNotFoundException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArrayAccessorTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArrayAccessorTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArrayAccessorTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testAppendPrependRemove()
    {
        $trait = $this->buildMock();

        $this->assertTrue($trait->isEmpty());
        $this->assertFalse($trait->isNotEmpty());

        $trait->set('a', 10)
            ->set('b', 20);
        $this->assertEquals(20, $trait->get('b'));

        $trait->add(21)
            ->appendMultiple([22, 23])
            ->prepend(9)
            ->prependMultiple([7, 8]);
        $this->assertEquals(
            [0, 1, 2, 'a', 'b', 3, 4, 5],
            $trait->getKeys()
        );
        $this->assertEquals(
            [7, 8, 9, 10, 20, 21, 22, 23],
            $trait->getValues()
        );

        $trait->removeKey(2);
        $this->assertEquals([7, 8, 10, 20, 21, 22, 23], $trait->getValues());

        $trait->removeKeys([3, 4]);
        $this->assertEquals([7, 8, 10, 20, 23], $trait->getValues());

        $trait->removeElement(10);
        $this->assertEquals([7, 8, 20, 23], $trait->getValues());

        $trait->removeElements([8, 20]);
        $this->assertEquals([7, 23], $trait->getValues());

        $this->assertFalse($trait->isEmpty());
        $this->assertTrue($trait->isNotEmpty());

        $trait->clear();
        $this->assertTrue($trait->isEmpty());
    }


    public function testGetWithDefault()
    {
        $trait = $this->buildMock();

        $trait->set('a', 42);

        $this->assertEquals(42, $trait->getOrDefault('a', 21));
        $this->assertEquals(21, $trait->getOrDefault('b', 21));
    }


    public function testGetWithNotExistKey()
    {
        $this->expectException(KeyNotFoundException::class);

        $trait = $this->buildMock();

        $trait->set('a', 42);
        $trait->get('b');
    }


    public function testPickTake()
    {
        $trait = new ArrayAccessorTraitTestDummy([5, 6, 7, 8, 9, 10]);

        /** @var ArrayAccessorTrait $picked */
        $picked = $trait->pick([1, 2]);
        $this->assertEquals([6, 7], $picked->getValues());
        $this->assertEquals(6, $trait->count());

        /** @var ArrayAccessorTrait $taken */
        $taken = $trait->take([2, 3, 4]);
        $this->assertEquals([7, 8, 9], $taken->getValues());
        $this->assertEquals(3, $trait->count());
        $this->assertEquals([5, 6, 10], $trait->getValues());
    }


    public function testPopShift()
    {
        $trait =
            new ArrayAccessorTraitTestDummy([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $this->assertEquals(1, $trait->shift());
        /** @var ArrayAccessorTraitTestDummy $shifted */
        $shifted = $trait->shiftMultiple(3);
        $this->assertEquals([2, 3, 4], $shifted->getValues());
        $this->assertEquals(6, $trait->count());

        $this->assertEquals(10, $trait->pop());
        /** @var ArrayAccessorTraitTestDummy $popped */
        $popped = $trait->popMultiple(3);
        $this->assertEquals([7, 8, 9], $popped->getValues());
        $this->assertEquals(2, $trait->count());


        // Pop and shift all
        $trait = new ArrayAccessorTraitTestDummy([1, 2, 3]);
        $popped = $trait->popMultiple(3);
        $this->assertTrue($trait->isEmpty());
        $this->assertEquals(3, $popped->count());

        $trait = new ArrayAccessorTraitTestDummy([1, 2, 3]);
        $shifted = $trait->shiftMultiple(3);
        $this->assertTrue($trait->isEmpty());
        $this->assertEquals(3, $shifted->count());
    }


    public function testRandom()
    {
        $trait = new ArrayAccessorTraitTestDummy([5, 6, 7, 8, 9, 10]);

        $element = $trait->randomElement();
        $this->assertTrue(in_array($element, $trait->getValues()));

        $elements = $trait->randomElements(3);
        $this->assertEquals(3, $elements->count());
    }


    public function testRandomKeysWithTooManyCount()
    {
        $this->expectException(ExceedCollectionSizeException::class);

        $trait = $this->buildMock();

        $trait->set('a', 42);

        $trait->randomKeys(3);
    }
}
