<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedArrayAccessorTrait;
use Fwolf\Common\Collection\Exception\ExceedCollectionSizeException;
use Fwolf\Common\Collection\Exception\KeyAndElementNotMatchException;
use Fwolf\Common\Collection\Exception\KeyNotFoundException;
use Fwolf\Common\Collection\TypedCollection;
use FwolfTest\Common\Collection\TypedCollectionTestDummy;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedArrayAccessorTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedArrayAccessorTrait
     */
    protected function buildMock(array $methods = null)
    {
        $methods = is_null($methods) ? [] : $methods;
        $methods = array_merge($methods, [
            'assertAllowedType',
            'assertAllowedTypes',
            'getElementIdentity',
        ]);

        $mock = $this->getMockBuilder(TypedArrayAccessorTrait::class)
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


    public function testAppendPrependRemove()
    {
        $trait = $this->buildMock();

        $this->assertTrue($trait->isEmpty());
        $this->assertFalse($trait->isNotEmpty());

        $trait->add(new TypedElementDummy(21));
        /** @var TypedElementDummy $element */
        $element = $trait->get(21);
        $this->assertEquals(21, $element->getIdentity());

        $trait->appendMultiple([
            new TypedElementDummy(22),
            new TypedElementDummy(23),
        ])
            ->prepend(new TypedElementDummy(9))
            ->prependMultiple([
                new TypedElementDummy(7),
                new TypedElementDummy(8),
            ]);
        $this->assertEquals([7, 8, 9, 21, 22, 23], $trait->getKeys());
        /** @var TypedElementDummy[] $values */
        $values = $trait->getValues();
        $this->assertEquals(21, $values[3]->getIdentity());

        $trait->removeKey(8);
        $this->assertEquals([7, 9, 21, 22, 23], $trait->getKeys());

        $trait->removeKeys([21, 22]);
        $this->assertEquals([7, 9, 23], $trait->getKeys());

        $trait->removeElement(new TypedElementDummy(9));
        $this->assertEquals([7, 23], $trait->getKeys());

        $trait->removeElements([new TypedElementDummy(7)]);
        $this->assertEquals([23], $trait->getKeys());

        $this->assertFalse($trait->isEmpty());
        $this->assertTrue($trait->isNotEmpty());

        $trait->clear();
        $this->assertTrue($trait->isEmpty());
    }


    public function testGetWithDefault()
    {
        $trait = $this->buildMock();

        $element42 = new TypedElementDummy(42);
        $element21 = new TypedElementDummy(21);
        $trait->set(42, $element42);

        /** @var TypedElementDummy $element */
        $element = $trait->getOrDefault(42, $element21);
        $this->assertEquals(42, $element->getIdentity());

        // Return default value
        $element = $trait->getOrDefault(300, $element21);
        $this->assertEquals(21, $element->getIdentity());
    }


    public function testGetWithNotExistKey()
    {
        $this->expectException(KeyNotFoundException::class);

        $trait = $this->buildMock();

        $trait->add(new TypedElementDummy(42));
        $trait->get('b');
    }


    public function testPickTake()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy(5),
            new TypedElementDummy(6),
            new TypedElementDummy(7),
            new TypedElementDummy(8),
            new TypedElementDummy(9),
            new TypedElementDummy(10)
        ]);

        /** @var TypedArrayAccessorTrait $picked */
        $picked = $trait->pick([6, 7]);
        $this->assertEquals([6, 7], $picked->getKeys());
        $this->assertEquals(6, $trait->count());

        /** @var TypedArrayAccessorTrait $taken */
        $taken = $trait->take([7, 8, 9]);
        $this->assertEquals([7, 8, 9], $taken->getKeys());
        $this->assertEquals(3, $trait->count());
        $this->assertEquals([5, 6, 10], $trait->getKeys());
    }


    public function testPopShift()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy(1),
            new TypedElementDummy(2),
            new TypedElementDummy(3),
            new TypedElementDummy(4),
            new TypedElementDummy(5),
            new TypedElementDummy(6),
            new TypedElementDummy(7),
            new TypedElementDummy(8),
            new TypedElementDummy(9),
            new TypedElementDummy(10)
        ]);
        $trait2 = clone $trait;
        $trait3 = clone $trait;

        /** @var TypedElementDummy $element */
        $element = $trait->shift();
        $this->assertEquals(1, $element->getIdentity());

        /** @var TypedArrayAccessorTrait $shifted */
        $shifted = $trait->shiftMultiple(3);
        $this->assertEquals([2, 3, 4], $shifted->getKeys());
        $this->assertEquals(6, $trait->count());

        /** @var TypedElementDummy $element */
        $element = $trait->pop();
        $this->assertEquals(10, $element->getIdentity());

        /** @var TypedArrayAccessorTrait $popped */
        $popped = $trait->popMultiple(3);
        $this->assertEquals([7, 8, 9], $popped->getKeys());
        $this->assertEquals(2, $trait->count());


        // Pop and shift all
        $popped = $trait2->popMultiple(10);
        $this->assertTrue($trait2->isEmpty());
        $this->assertEquals(10, count($popped->getKeys()));

        $shifted = $trait3->shiftMultiple(10);
        $this->assertTrue($trait3->isEmpty());
        $this->assertEquals(10, count($shifted->getKeys()));
    }


    public function testRandom()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy(5),
            new TypedElementDummy(6),
            new TypedElementDummy(7),
            new TypedElementDummy(8),
            new TypedElementDummy(9),
            new TypedElementDummy(10)
        ]);

        /** @var TypedElementDummy $element */
        $element = $trait->randomElement();
        $this->assertTrue(
            in_array($element->getIdentity(), $trait->getKeys())
        );

        /** @var TypedCollection $elements */
        $elements = $trait->randomElements(3);
        $this->assertEquals(3, $elements->count());
    }


    public function testRandomKeysWithTooManyCount()
    {
        $this->expectException(ExceedCollectionSizeException::class);

        $trait = $this->buildMock();

        $trait->add(new TypedElementDummy(42));

        $trait->randomKeys(3);
    }


    public function testSetWithInvalidKey()
    {
        $this->expectException(KeyAndElementNotMatchException::class);

        $trait = $this->buildMock();

        $trait->set(21, new TypedElementDummy(42));
    }
}
