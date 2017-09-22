<?php

namespace FwolfTest\Common\Collection;

use Fwolf\Common\Collection\Collection;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class CollectionTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | Collection
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(Collection::class)
            ->setMethods($methods)
            ->getMock();

        return $mock;
    }


    public function testConstructor()
    {
        $collection = new Collection([1, 3, 2]);
        $this->assertEquals(3, $collection->count());
    }
}
