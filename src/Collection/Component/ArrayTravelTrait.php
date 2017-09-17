<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\Collection;
use Fwolf\Common\Collection\CollectionInterface;

/**
 * Implement of {@link ArrayTravelInterface}
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait ArrayTravelTrait
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
    public function each(callable $func)
    {
        foreach ($this->elements as $key => $val) {
            $func($key, $val);
        }

        return $this;
    }


    /**
     * Call function on each element, return new collection of function result
     *
     * @param   callable $func Take element as first parameter.
     * @return  CollectionInterface
     */
    public function map(callable $func)
    {
        $resultAr = array_map($func, $this->elements);

        return new Collection($resultAr);
    }


    /**
     * Call function with each element, return original collection(self)
     *
     * If the collection element is object, they maybe changed by func.
     *
     * @param   callable $func Take element as first parameter.
     * @return  $this
     */
    public function walk(callable $func)
    {
        array_walk($this->elements, $func);

        return $this;
    }
}
