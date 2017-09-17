<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\CollectionInterface;

/**
 * Do something on each element of collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ArrayTravelInterface
{
    /**
     * Call function like foreach loop
     *
     * If the collection element is object, they maybe changed by func.
     *
     * @param   callable $func Take key and value of element as first and
     *                         second parameter.
     * @return  $this
     */
    public function each(callable $func);


    /**
     * Call function on each element, return new collection of function result
     *
     * @param   callable $func Take element as first parameter.
     * @return  CollectionInterface
     */
    public function map(callable $func);


    /**
     * Call function with each element, return original collection(self)
     *
     * If the collection element is object, they maybe changed by func.
     *
     * @param   callable $func Take element as first parameter.
     * @return  $this
     */
    public function walk(callable $func);
}
