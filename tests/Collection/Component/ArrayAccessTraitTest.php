<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArrayAccessTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArrayAccessTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | ArrayAccessTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(ArrayAccessTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        return $mock;
    }


    public function testAccessors()
    {
        $trait = $this->buildMock();

        $trait->elements = [];

        $this->assertFalse($trait->offsetExists('foo'));

        $trait->offsetSet('foo', 42);
        $this->assertEquals(42, $trait->offsetGet('foo'));
        $this->assertTrue($trait->offsetExists('foo'));

        $trait->offsetUnset('foo');
        $this->assertFalse($trait->offsetExists('foo'));
    }
}
