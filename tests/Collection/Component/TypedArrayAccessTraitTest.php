<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedArrayAccessTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedArrayAccessTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedArrayAccessTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(TypedArrayAccessTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        {
            $mock->elements = [];
            $mock->allowedType = 'stdClass';
        }

        return $mock;
    }


    public function testAccessors()
    {
        $trait = $this->buildMock(['assertAllowedType']);
        $trait->expects($this->exactly(1))
            ->method('assertAllowedType');


        $this->assertFalse($trait->offsetExists('foo'));

        $trait->offsetSet('foo', new TypedElementDummy(42));
        /** @var TypedElementDummy $element */
        $element = $trait->offsetGet('foo');
        $this->assertEquals(42, $element->getIdentity());
        $this->assertTrue($trait->offsetExists('foo'));

        $trait->offsetUnset('foo');
        $this->assertFalse($trait->offsetExists('foo'));
    }
}
