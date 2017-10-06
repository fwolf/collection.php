<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedArraySearchTrait;
use FwolfTest\Common\Collection\TypedCollectionTestDummy;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedArraySearchTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedArraySearchTrait
     */
    protected function buildMock(array $methods = null)
    {
        $methods = is_null($methods) ? [] : $methods;
        $methods = array_merge($methods, [
            'assertAllowedType',
            'assertAllowedTypes',
            'getElementIdentity',
        ]);

        $mock = $this->getMockBuilder(TypedArraySearchTrait::class)
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


    public function testHasElement()
    {
        $element1 = new TypedElementDummy(1);
        $element2 = new TypedElementDummy(2);
        $element3 = new TypedElementDummy(3);
        $trait = new TypedCollectionTestDummy([
            $element1,
            $element2,
        ]);

        $this->assertTrue($trait->hasElement($element2));
        $this->assertFalse($trait->hasElement($element3));
    }


    /**
     * Element compare may various, here we mock compare method to false
     */
    public function testIndexOfFailByCompareElement()
    {
        $trait = $this->buildMock(['compareElement']);
        $trait->expects($this->once())
            ->method('compareElement')
            ->willReturn(-1);

        $element1 = new TypedElementDummy(1);
        $element2 = new TypedElementDummy(2);
        $trait->elements = [1 => $element1, 2 => $element2];

        $this->assertFalse($trait->hasElement($element2));
    }


    public function testMatching()
    {
        $trait = new TypedCollectionTestDummy([
            new TypedElementDummy(1),
            new TypedElementDummy(2),
            new TypedElementDummy(3),
            new TypedElementDummy(4),
        ]);

        $predicate = function (TypedElementDummy $element) {
            return $element->getIdentity() >= 3;
        };
        // Matching result will have new array keys
        $matching = $trait->matching($predicate);
        $this->assertEquals([3, 4], $matching->getKeys());
        /** @var TypedElementDummy $element */
        $element = $matching[4];
        $this->assertEquals(4, $element->getIdentity());
    }
}
