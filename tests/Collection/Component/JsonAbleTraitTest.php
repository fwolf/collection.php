<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\JsonAbleTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class JsonAbleTraitTest extends PHPUnitTestCase
{
    /**
     * @param   string[] $methods
     * @return  MockObject | JsonAbleTrait
     */
    protected function buildMock(array $methods = null)
    {
        $mock = $this->getMockBuilder(JsonAbleTrait::class)
            ->setMethods($methods)
            ->getMockForTrait();

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->elements = [];

        return $mock;
    }


    public function testToAndFromJson()
    {
        $trait = $this->buildMock();
        $trait->elements = ['foo', 'bar'];
        $this->assertEquals('["foo","bar"]', $trait->toJson());


        $trait = $this->buildMock();
        $trait->fromJson('["foo","bar"]');
        $this->assertEquals(['foo', 'bar'], $trait->elements);
    }
}
