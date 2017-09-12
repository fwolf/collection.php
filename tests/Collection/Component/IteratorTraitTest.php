<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\IteratorTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class IteratorTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | IteratorTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(IteratorTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        return $mock;
    }


    public function testAccessors()
    {
        $trait = $this->buildMock();

        $trait->elements = [1, 2, 3];
        $this->assertEquals(1, $trait->current());
        $trait->next();
        $this->assertEquals(2, $trait->current());
        $this->assertEquals(1, $trait->key());  // Ar key start from 0
        $trait->rewind();
        $this->assertEquals(1, $trait->current());
        $trait->next(); // 2
        $trait->next(); // 3
        $this->assertEquals(3, $trait->current());
        $this->assertTrue($trait->valid());
        $trait->next(); // Beyond end
        $this->assertFalse($trait->valid());
    }
}
