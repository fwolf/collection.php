<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\TypedArrayAbleTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedArrayAbleTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedArrayAbleTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(TypedArrayAbleTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        {
            $mock->elements = [];
            $mock->allowedType = 'stdClass';
        }

        return $mock;
    }


    public function testToAndFromArray()
    {
        $trait = $this->buildMock();

        $trait->elements = [
            new TypedElementDummy(1),
            new TypedElementDummy(3),
            new TypedElementDummy(2),
        ];

        $exportAr = $trait->toArray();


        $trait2 = $this->buildMock(['assertAllowedTypes']);
        $trait2->method('assertAllowedTypes')
            ->willReturnSelf();

        $trait2->fromArray($exportAr);
        /** @var TypedElementDummy[] $elements */
        $elements = $trait2->elements;
        $this->assertEquals(1, $elements[0]->getIdentity());
        $this->assertEquals(3, $elements[1]->getIdentity());
        $this->assertEquals(2, $elements[2]->getIdentity());
    }
}
