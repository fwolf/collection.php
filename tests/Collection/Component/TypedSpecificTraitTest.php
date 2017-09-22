<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedSpecificTrait;
use Fwolf\Common\Collection\Exception\NotAllowedTypeException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedSpecificTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedSpecificTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(TypedSpecificTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        {
            $mock->elements = [];
            $mock->allowedType = 'stdClass';
        }

        return $mock;
    }


    public function testAssertAllowedType()
    {
        $this->expectException(NotAllowedTypeException::class);

        $trait = $this->buildMock();
        $trait->assertAllowedType(new \DateTime());
    }


    public function testCompareElement()
    {
        $trait = $this->buildMock();

        $object1 = new \stdClass();
        $trait->getElementIdentity($object1);   // Smaller identity
        $object2 = new \stdClass();
        $trait->getElementIdentity($object2);

        $this->assertEquals(
            0,
            $trait->compareElement($object1, clone $object1)
        );
        $this->assertEquals(-1, $trait->compareElement($object1, $object2));
        $this->assertEquals(1, $trait->compareElement($object2, $object1));
    }


    public function testGetElementIdentity()
    {
        $trait = $this->buildMock();

        $object = new \stdClass();
        $identity1 = $trait->getElementIdentity($object);
        $identity2 = $trait->getElementIdentity($object);
        $this->assertEquals($identity1, $identity2);
    }


    public function testIsAllowedType()
    {
        $trait = $this->buildMock();

        $this->assertTrue($trait->isAllowedType(new \stdClass()));
        $this->assertFalse($trait->isAllowedType(new \DateTime()));
    }
}
