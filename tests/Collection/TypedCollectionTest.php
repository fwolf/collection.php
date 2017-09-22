<?php

namespace FwolfTest\Common\Collection;

use Fwolf\Common\Collection\Exception\NotAllowedTypeException;
use Fwolf\Common\Collection\TypedCollection;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedCollectionTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | TypedCollection
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(TypedCollection::class)
            ->setMethods($methods)
            ->getMock();

        return $mock;
    }


    public function testConstructor()
    {
        $collection = new TypedCollectionTestDummy([new \stdClass()]);
        $collection->appendMultiple([new \stdClass(), new \stdClass()]);
        $this->assertEquals(3, $collection->count());
    }


    public function testConstructorFail()
    {
        $this->expectException(NotAllowedTypeException::class);

        new TypedCollectionTestDummy([new \DateTime()]);
    }
}
