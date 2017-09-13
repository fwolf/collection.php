<?php

namespace Fwolf\Common\Collection\Component;

/**
 * Implement of {@link ArrayAbleInterface}
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait ArrayAbleTrait
{
    /**
     * Load from PHP array, will clear present data
     *
     * @param   array $arrayData
     * @return  $this
     */
    public function fromArray(array $arrayData)
    {
        $this->elements = $arrayData;

        return $this;
    }


    /**
     * To native PHP array
     *
     * @return  array
     */
    public function toArray()
    {
        return $this->elements;
    }
}
