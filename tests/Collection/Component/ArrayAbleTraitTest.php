<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArrayAbleTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArrayAbleTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArrayAbleTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArrayAbleTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        return $mock;
    }


    public function testToAndFromArray()
    {
        $trait = $this->buildMock();

        $trait->elements = [1, 3, 2];

        $exportAr = $trait->toArray();

        $trait2 = $this->buildMock()->fromArray($exportAr);
        $this->assertEquals(1, $trait2->elements[0]);
        $this->assertEquals(3, $trait2->elements[1]);
        $this->assertEquals(2, $trait2->elements[2]);
    }
}
