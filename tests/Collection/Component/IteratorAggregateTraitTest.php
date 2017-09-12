<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\IteratorAggregateTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;
use Traversable;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class IteratorAggregateTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | IteratorAggregateTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(IteratorAggregateTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        return $mock;
    }


    public function testCount()
    {
        $trait = $this->buildMock();

        $trait->elements = [1, 2, 3];
        $iterator = $trait->getIterator();
        $this->assertInstanceOf(Traversable::class, $iterator);

        // Test by do foreach
        $sum = 0;
        foreach ($iterator as $value) {
            $sum += $value;
        }
        $this->assertEquals(6, $sum);
    }
}
