<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\CountableTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class CountableTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | CountableTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(CountableTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        return $mock;
    }


    public function testCount()
    {
        $trait = $this->buildMock();

        $trait->elements = [1, 2, 3];
        $this->assertEquals(3, $trait->count());
    }
}
